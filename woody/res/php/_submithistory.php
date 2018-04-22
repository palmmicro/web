<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stockhis.php');

// https://danjuanapp.com/djmodule/value-center

function _sqlMergeStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
{
    if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
    {
        SqlUpdateStockHistory($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
    else
    {
        SqlInsertStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
}

/*
function _getHistoryQuotesYMD($str)
{
    $arLines = explode("\n", $str, 3);
    $arWords = explode(',', $arLines[1], 2);
//    return explode('-', $arWords[0]);
    return $arWords[0];
}

function _getPastQuotes($sym, $strFileName)
{
    if (($str = IsNewDailyQuotes($sym, $strFileName, false, _getHistoryQuotesYMD)) === false)
    {
        $str = GetYahooPastQuotes($sym->GetYahooSymbol(), MAX_QUOTES_DAYS);
        file_put_contents($strFileName, $str);
    }
    return $str;
}

function _oldUpdateYahooHistory($strStockId, $sym)
{
    $strSymbol = $sym->strSymbol;
    $strFileName = DebugGetYahooHistoryFileName($strSymbol);
    $str = _getPastQuotes($sym, $strFileName);
    if (IsYahooStrError($str))
    {
        DebugString('IsYahooStrError returned ture with symbol - '.$strSymbol);
        return;
    }

    DebugString('StockUpdateYahooHistory with symbol - '.$strSymbol);
    $arYahoo = explode("\n", $str);
    foreach ($arYahoo as $strLine)
    {
        $ar = explode(',', $strLine);
//        DebugString($ar[0].' '.$ar[1].' '.$ar[2].' '.$ar[3].' '.$ar[4].' '.$ar[5].' '.$ar[6]);
        $strDate = $ar[0];
        if ((!empty($strDate)) && ($strDate != 'Date'))
        {
            _sqlMergeStockHistory($strStockId, $strDate, $ar[1], $ar[2], $ar[3], $ar[4], $ar[5], $ar[6]);
        }
    }
}
*/

function _webUpdateYahooHistory($strStockId, $strYahooSymbol)
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
            $ymd_begin = new YMDTick($iTimeBegin);
            $ymd = new YMDTick($iTime);
            DebugString(sprintf('_webUpdateYahooHistory %s %d from %s to %s', $strYahooSymbol, $iVal, $ymd_begin->GetYMD(), $ymd->GetYMD()));
        }
        
        for ($j = 0; $j < $iVal; $j ++)
        {
            $ymd = new YMDTick(strtotime($arMatch[$j][1]));
            $strDate = $ymd->GetYMD();
            
            $ar = array();
            $str = $strDate;
            for ($i = 0; $i < 6; $i ++)
            {
                $strNoComma = str_replace(',', '', $arMatch[$j][$i + 2]); 
                $ar[] = $strNoComma;
                $str .= ' '.$strNoComma; 
            }
            _sqlMergeStockHistory($strStockId, $strDate, $ar[0], $ar[1], $ar[2], $ar[3], $ar[5], $ar[4]);
        }
        $iTime = $iTimeBegin;
    }
    DebugString(sprintf('_webUpdateYahooHistory %s total %d', $strYahooSymbol, $iTotal));
}

function _isInvalidDate($strYMD)
{
    $ymd = new YMDString($strYMD);
    if ($ymd->IsWeekend())      return true;
    if ($ymd->IsFuture())       return true;
    
    $ymd_oldest = new YMDString('2000-01-01');
    if ($ymd->GetTick() < $ymd_oldest->GetTick())                 return true;
    return false;
}

function _cleanInvalidStockHistory($strStockId)
{
    $ar = array();
    if ($result = SqlGetStockHistory($strStockId, 0, 0)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($history['date']))
            {
                $ar[] = $history['id'];
            }
        }
        @mysql_free_result($result);
    }

    foreach ($ar as $strId)
    {
        SqlDeleteTableDataById(TABLE_STOCK_HISTORY, $strId);
    }
}

function _cleanInvalidHistory($strTableName)
{
    $ar = array();
    if ($result = SqlGetTableData($strTableName, false, false, false)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($history['date']))
            {
                $ar[] = $history['id'];
            }
        }
        @mysql_free_result($result);
    }

    $iCount = count($ar);
    DebugString($strTableName.' - invalid date: '.strval($iCount)); 
    foreach ($ar as $strId)
    {
        SqlDeleteTableDataById($strTableName, $strId);
    }
}

function _submitStockHistory($strStockId, $strSymbol)
{
    if (AcctIsAdmin() == false)     return;
    
    unlinkEmptyFile(DebugGetConfigFileName($strSymbol));
    
    $sym = new StockSymbol($strSymbol);
//    _oldUpdateYahooHistory($strStockId, $sym);
    $sym->SetTimeZone();
    _webUpdateYahooHistory($strStockId, $sym->GetYahooSymbol());
    if ($sym->IsSymbolA() || $sym->IsSymbolH())
    {   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
        if ($sym->IsIndex() == false)
        {
            SqlDeleteStockHistoryWithZeroVolume($strStockId);
        }
    }
    _cleanInvalidStockHistory($strStockId);
//    _cleanInvalidHistory(TABLE_FUND_HISTORY);
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
