<?php

// Every market trading from 9 to 17?
define ('STOCK_HOUR_BEGIN', 9);
define ('STOCK_HOUR_END', 16);

function _isMarketTrading($sym, $iTime)
{
    $ymd = new YMDTick($iTime);
    if ($ymd->IsTradingDay())
    {
        $iHour = $ymd->GetHour(); 
        if ($sym->IsSymbolA())
        {
            if ($iHour < STOCK_HOUR_BEGIN || $iHour > 15)     return false;
        }
        else if ($sym->IsSymbolH())
        {
            if ($iHour < STOCK_HOUR_BEGIN || $iHour > STOCK_HOUR_END)     return false;
        }
        else
        {   // US extended hours trading from 4am to 8pm
            if ($iHour < 4 || $iHour > 20)     return false;
        }
    }
    else 
    {
        return false;   // do not trade on holiday and weekend
    }
    return true;
}

function GetEastMoneyForexDateTime($ar)
{
    return explode(' ', $ar[27]);
}

function _GetEastMoneyQuotesYMD($str)
{
    $ar = explode(',', $str);
    if (count($ar) > 27)
    {
        list($strDate, $strTime) = GetEastMoneyForexDateTime($ar); 
        return $strDate;
    }
    return false;
}

function _GetFundQuotesYMD($str)
{
    $arWords = explode(',', $str);
    return $arWords[4];
}

function IsNewDailyQuotes($sym, $strFileName, $bSameDay, $callback)
{
    clearstatcache(true, $strFileName);
    $sym->SetTimeZone();
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        if (($strYMD = call_user_func($callback, $str)) == false)  return false;
        $ymd = new YMDString($strYMD);
        
        $ymd_now = new YMDNow();
        $iFileTime = filemtime($strFileName);
        if ($bSameDay)
        {
            if ($ymd_now->GetYMD() == $strYMD)
            {
                if (($iFileTime - STOCK_HOUR_BEGIN * SECONDS_IN_HOUR) > $ymd->GetTick())  return $str;    // We already have today's data
            }
        }
        else
        {
            if (($ymd_now->GetTick() - STOCK_HOUR_END * SECONDS_IN_HOUR) < $ymd->GetNextTradingDayTick())     return $str;   // We already have yesterday or last Friday's history quotes.
        }
        
        $ymd_file = new YMDTick($iFileTime);
        if ($ymd_now->IsSameHour($ymd_file) && $ymd_now->IsSameDay($ymd_file))  return $str;   // same hour and same day
        else                                                                               return false;
    }
    return false;
}

function StockNeedNewQuotes($sym, $strFileName)
{
    clearstatcache(true, $strFileName);
    $sym->SetTimeZone();
    if (file_exists($strFileName))
    {
        $ymd = new YMDNow();
        if ($ymd->IsNewFile($strFileName))       return false;   // update on every minute
 
        $iFileTime = filemtime($strFileName);
		$iCurTime = $ymd->GetTick();
        if ($iCurTime > ($iFileTime + 6 * SECONDS_IN_HOUR))     return true;   // always update after 6 hours
        
        if (_isMarketTrading($sym, $iFileTime))    return true;
        else 
        {
            if (_isMarketTrading($sym, $iCurTime))    return true;
            else                                return false;
        }
    }
    return true;
}

function ForexAndFutureNeedNewFile($strFileName, $strTimeZone)
{
    clearstatcache(true, $strFileName);
    date_default_timezone_set($strTimeZone);
    if (file_exists($strFileName))
    {
        $ymd = new YMDNow();
        if ($ymd->IsNewFile($strFileName))       return false;   // update on every minute
        
        $ymd_file = new YMDTick(filemtime($strFileName));
        if ($ymd_file->IsWeekDay())    return true;
        else 
        {
            if ($ymd->IsWeekDay())    return true;
            else                        return false;
        }
    }
    return true;
}

function _writePrefetchFiles($arFileName, $arLine, $iCount)
{
    if (count($arLine) < $iCount)  return;

    for ($i = 0; $i < $iCount; $i ++)
    {
        file_put_contents($arFileName[$i], $arLine[$i]);
    }
}

function _prefetchGoogleData($arSymbol)
{
    $strSymbols = '';
    $arFileName = array();
    
    foreach ($arSymbol as $str => $strSymbol)
    {
        $strFileName = DebugGetGoogleFileName($strSymbol);
        $sym = new StockSymbol($strSymbol);
        if (StockNeedNewQuotes($sym, $strFileName) == false)  continue;
        $arFileName[] = $strFileName; 
        $strSymbols .= $str.',';
    }
    if (($iCount = count($arFileName)) < 2)    return;
    $strSymbols = rtrim($strSymbols, ',');
    
    if (($str = GetGoogleQuotes($strSymbols)) == false)   return;
    $ar = explode(',{', $str);
    for ($i = 0; $i < $iCount; $i ++)
    {
        $str = $ar[$i];
        if (substr($str, 0, 1) != '{')  $str = '{'.$str;
        file_put_contents($arFileName[$i], $str);
    }
}

function PrefetchGoogleStockData($arSymbol)
{
    $arUnknown = array();
    $arPrefetch = array();
    foreach ($arSymbol as $strSymbol)
    {
        $sym = new StockSymbol($strSymbol);
        if ($strGoogleSymbol = $sym->GetGoogleSymbol())
        {
            $arPrefetch[$strGoogleSymbol] = $strSymbol;
        }
        else
        {
            $arUnknown[] = $strSymbol;
        }
    }
//    _prefetchGoogleData($arPrefetch); bug to be fixed for this function
    return $arUnknown;
}

function PrefetchYahooData($arSymbol)
{
    $strSymbols = '';
    $arFileName = array();
    
    foreach ($arSymbol as $strSymbol)
    {
        $strFileName = DebugGetYahooFileName($strSymbol);
        $sym = new StockSymbol($strSymbol);
        if (StockNeedNewQuotes($sym, $strFileName) == false)  continue;
        $arFileName[] = $strFileName; 
        $strSymbols .= $sym->GetYahooSymbol().'+';
    }
    if (($iCount = count($arFileName)) < 2)    return;
    $strSymbols = rtrim($strSymbols, '+');
    
    if (($str = GetYahooQuotes($strSymbols)) == false)   return;
    $arLine = explode("\n", $str);
    _writePrefetchFiles($arFileName, $arLine, $iCount);
}

function PrefetchEastMoneyData($arSymbol)
{
    $strSymbols = '';
    $arFileName = array();
    
    foreach ($arSymbol as $strSymbol)
    {
        $strFileName = DebugGetEastMoneyFileName($strSymbol);
        $sym = new StockSymbol($strSymbol);
        if ($sym->IsEastMoneyForex())
        {   // forex reference rate USCNY/HKCNY
            if (IsNewDailyQuotes($sym, $strFileName, true, _GetEastMoneyQuotesYMD))   continue;
        }
        $arFileName[] = $strFileName; 
        $strSymbols .= ForexGetEastMoneySymbol($strSymbol).','; 
    }
    if (($iCount = count($arFileName)) < 2)    return;
    $strSymbols = rtrim($strSymbols, ',');
    
    if (($str = GetEastMoneyQuotes($strSymbols)) == false)   return;
    $arLine = explode('",', $str);
    _writePrefetchFiles($arFileName, $arLine, $iCount);
}

function _prefetchSinaData($arSym)
{
    $strSymbols = '';
    $arFileName = array();
    
    foreach ($arSym as $str => $sym)
    {
        $strFileName = DebugGetSinaFileName($str);
		if ($sym->IsSinaFund())
        {   // fund, IsSinaFund must be called before IsSinaFuture
            if (IsNewDailyQuotes($sym, $strFileName, false, _GetFundQuotesYMD))       continue;
        }
        else if ($sym->IsSinaFuture() || $sym->IsSinaForex())
        {   // forex and future
            if (ForexAndFutureNeedNewFile($strFileName, ForexAndFutureGetTimezone()) == false)    continue;
        }
        else
        {   // Stock symbol
            if (StockNeedNewQuotes($sym, $strFileName) == false)  continue;
        }
        $arFileName[] = $strFileName; 
        $strSymbols .= $str.',';
    }
    if (($iCount = count($arFileName)) < 2)    return;
    $strSymbols = rtrim($strSymbols, ',');
    
    if (($str = GetSinaQuotes($strSymbols)) == false)   return;
    $arLine = explode("\n", $str);
    _writePrefetchFiles($arFileName, $arLine, $iCount);
}

function PrefetchSinaStockData($arSymbol)
{
    $arUnknown = array();
    $arPrefetch = array();
    foreach ($arSymbol as $strSymbol)
    {
        if ($strSymbol)
        {
            $sym = new StockSymbol($strSymbol);
            if ($sym->IsSinaFund() || $sym->IsSinaForex())
            {   // IsSinaFund must be called before IsSinaFuture
                $arPrefetch[$strSymbol] = $sym;
            }
            else if ($sym->IsSinaFuture())
            {
                $arPrefetch[$strSymbol] = $sym;
            }
            else if ($sym->IsEastMoneyForex())
            {	// Only WX call may into this, nothing need to be done. Do not put it in $arUnknown neither!
            }	
            else if ($strSinaSymbol = $sym->GetSinaSymbol())
            {
                $arPrefetch[$strSinaSymbol] = $sym;
                if ($sym->IsFundA())
                {
                	$strSinaFundSymbol = $sym->GetSinaFundSymbol();
                	$arPrefetch[$strSinaFundSymbol] = new StockSymbol($strSinaFundSymbol);
                }
            }
            else
            {
                $arUnknown[] = $strSymbol;
            }
        }
    }
    _prefetchSinaData($arPrefetch);
    return $arUnknown;
}

?>
