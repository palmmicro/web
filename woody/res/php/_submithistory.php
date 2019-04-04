<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stockhis.php');

// https://danjuanapp.com/djmodule/value-center

function _webUpdateSinaHistory($sql, $sym)
{
    $oldest_ymd = new OldestYMD();
    $iYearOldest = $oldest_ymd->GetYear();
    
	$ymd = new NowYMD();
	$iYear = $ymd->GetYear();
	$iSeason = $ymd->GetSeason();
	$iTotal = 0;
	while ($iTotal < MAX_QUOTES_DAYS)
	{
        $str = SinaGetStockHistory($sym, $iYear, $iSeason);
        $arMatch = preg_match_sina_history($str);
        foreach ($arMatch as $ar)
        {
        	$sql->Write($ar[1], $ar[2], $ar[3], $ar[5], $ar[4], $ar[6], $ar[4]);
        	$iTotal ++;
		}
		$iSeason --;
		if ($iSeason == 0)
		{
			$iSeason = 4;
			$iYear --;
			if ($iYear < $iYearOldest)	break;
		}
	}
    DebugVal($iTotal, $sym->GetSymbol().' total');
}

function _webUpdateYahooHistory($sql, $strYahooSymbol)
{
    $iTime = time();
    $iTotal = 0;
    $iMax = 100;
    $iMaxSeconds = $iMax * SECONDS_IN_DAY;
    for ($k = 0; $k < MAX_QUOTES_DAYS; $k += $iMax)
    {
        $iTimeBegin = $iTime - $iMaxSeconds;
        $str = YahooGetStockHistory($strYahooSymbol, $iTimeBegin, $iTime);

        $arMatch = preg_match_yahoo_history($str);
        $iVal = count($arMatch);
        $iTotal += $iVal;
        if ($iVal < $iMax / 2)
        {
            $begin_ymd = new TickYMD($iTimeBegin);
            $ymd = new TickYMD($iTime);
            DebugString(sprintf('_webUpdateYahooHistory %s %d from %s to %s', $strYahooSymbol, $iVal, $begin_ymd->GetYMD(), $ymd->GetYMD()));
        }
        
        for ($j = 0; $j < $iVal; $j ++)
        {
            $ymd = new TickYMD(strtotime($arMatch[$j][1]));
            $strDate = $ymd->GetYMD();
            
            $ar = array();
            $str = $strDate;
            for ($i = 0; $i < 6; $i ++)
            {
                $strNoComma = str_replace(',', '', $arMatch[$j][$i + 2]); 
                $ar[] = $strNoComma;
                $str .= ' '.$strNoComma; 
            }
            $sql->Write($strDate, $ar[0], $ar[1], $ar[2], $ar[3], $ar[5], $ar[4]);
        }
        $iTime = $iTimeBegin;
    }
    DebugVal($iTotal, $strYahooSymbol.' total');
}
/*
function _isInvalidDate($strYMD)
{
    $ymd = new StringYMD($strYMD);
    if ($ymd->IsWeekend())      return true;
    if ($ymd->IsFuture())       return true;
    
    $oldest_ymd = new OldestYMD();
    if ($ymd->GetTick() < $oldest_ymd->GetTick())                 return true;
    return false;
}

function _cleanInvalidStockHistory($sql)
{
    $ar = array();
    if ($result = $sql->GetAll()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($record['date']))
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }

    foreach ($ar as $strId)
    {
        $sql->DeleteById($strId);
    }
}

function _cleanInvalidHistory($strTableName)
{
    $ar = array();
    if ($result = SqlGetTableData($strTableName)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($record['date']))
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }

    $iCount = count($ar);
    DebugVal($iCount, $strTableName.' - invalid date'); 
    foreach ($ar as $strId)
    {
        SqlDeleteTableDataById($strTableName, $strId);
    }
}
*/
function _submitStockHistory($strStockId, $strSymbol)
{
    if (AcctIsAdmin() == false)     return;
    
    unlinkConfigFile($strSymbol);
    $sym = new StockSymbol($strSymbol);
    $sym->SetTimeZone();
	$sql = new StockHistorySql($strStockId);
	if ($sym->IsIndexA())
	{
		_webUpdateSinaHistory($sql, $sym);
	}
	else
	{
		_webUpdateYahooHistory($sql, $sym->GetYahooSymbol());
		if ($sym->IsSymbolA() || $sym->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
			if ($sym->IsIndex() == false)
			{
				$sql->DeleteByZeroVolume();
			}
		}
	}
    $sql->DeleteInvalidDate();
}

    AcctNoAuth();
	if ($strStockId = UrlGetQueryValue('id'))
	{
	    if ($strSymbol = SqlGetStockSymbol($strStockId))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	else if ($strSymbol = UrlGetQueryValue('symbol'))
	{
	    if ($strStockId = SqlGetStockId($strSymbol))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	SwitchToSess();
	
?>
