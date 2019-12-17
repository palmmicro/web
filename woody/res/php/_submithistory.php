<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/stockhis.php');

// https://danjuanapp.com/djmodule/value-center

function _webUpdateSinaHistory($his_sql, $sym)
{
    $oldest_ymd = new OldestYMD();
    $iYearOldest = $oldest_ymd->GetYear();
    
	$ymd = new NowYMD();
	$iYear = $ymd->GetYear();
	$iSeason = $ymd->GetSeason();
	$iTotal = 0;
	while ($iTotal < MAX_QUOTES_DAYS)
	{
        if ($str = SinaGetStockHistory($sym, $iYear, $iSeason))
        {
        	$arMatch = preg_match_sina_history($str);
        	foreach ($arMatch as $ar)
        	{
        		$his_sql->WriteHistory($ar[1], $ar[2], $ar[3], $ar[5], $ar[4], $ar[6], $ar[4]);
        		$iTotal ++;
        	}
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

function _webUpdateYahooHistory($his_sql, $strYahooSymbol)
{
    $iTime = time();
    $iTotal = 0;
    $iMax = 100;
    $iMaxSeconds = $iMax * SECONDS_IN_DAY;
    for ($k = 0; $k < MAX_QUOTES_DAYS; $k += $iMax)
    {
        $iTimeBegin = $iTime - $iMaxSeconds;
        if ($str = YahooGetStockHistory($strYahooSymbol, $iTimeBegin, $iTime))
        {
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
        		$his_sql->WriteHistory($strDate, $ar[0], $ar[1], $ar[2], $ar[3], $ar[5], $ar[4]);
        	}
        }
        
        $iTime = $iTimeBegin;
    }
    DebugVal($iTotal, $strYahooSymbol.' total');
}

function _submitStockHistory($ref)
{
	$his_sql = $ref->GetHistorySql();
    $strSymbol = $ref->GetSymbol();
    
    unlinkConfigFile($strSymbol);
    $ref->SetTimeZone();
	if ($ref->IsIndexA())
	{
		_webUpdateSinaHistory($his_sql, $ref);
	}
	else
	{
		_webUpdateYahooHistory($his_sql, $ref->GetYahooSymbol());
		if ($ref->IsSymbolA() || $ref->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
			if ($ref->IsIndex() == false)
			{
				$his_sql->DeleteByZeroVolume();
			}
		}
	}
	
    $iCount = $his_sql->DeleteInvalidDate();
	DebugVal($iCount, 'Invalid date'); 
}

    $acct = new SymbolAcctStart();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
	        _submitStockHistory($ref);
	    }
	}
	$acct->Back();
	
?>
