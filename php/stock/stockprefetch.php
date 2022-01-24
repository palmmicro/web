<?php
define('PREFETCH_INTERVAL', (SECONDS_IN_MIN - 10));

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
/*
function _GetFundQuotesYMD($str)
{
    $ar = explode(',', $str);
    if (count($ar) > 4)	return $ar[4];
    return false;
}
*/
function IsNewDailyQuotes($sym, $strFileName, $callback)
{
    $sym->SetTimeZone();
    clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        if (($strYMD = call_user_func($callback, $str)) == false)  return false;
        
//        DebugString('StringYMD in IsNewDailyQuotes');
        $ymd = new StringYMD($strYMD);
        
        $now_ymd = new NowYMD();
        $iFileTime = filemtime($strFileName);
        if (in_arrayQdii($sym->GetSymbol()))
        {
            if (($now_ymd->GetTick() - STOCK_HOUR_END * SECONDS_IN_HOUR) < $ymd->GetNextTradingDayTick())     return $str;	// We already have yesterday or last Friday's history quotes.
        }
        else
        {
            if ($now_ymd->IsSameDay($ymd))
            {
                if (($iFileTime - STOCK_HOUR_BEGIN * SECONDS_IN_HOUR) > $ymd->GetTick())  return $str;    // We already have today's data
            }
        }
        
        $file_ymd = new TickYMD($iFileTime);
        if ($now_ymd->IsSameHour($file_ymd) && $now_ymd->IsSameDay($file_ymd))  return $str;   // same hour and same day
        else                                                                               return false;
    }
    return false;
}

function SinaFundNeedFile($sym, $strFileName)
{
	clearstatcache(true, $strFileName);
	if (file_exists($strFileName) == false)	return true;

	if ($strDigit = $sym->IsSinaFund())
	{
   		if ($strSymbol = BuildChineseFundSymbol($strDigit))		$sym = new StockSymbol($strSymbol);
   		else
   		{
   			DebugString('SinaFundNeedFile unknown symbol:'.$sym->GetSymbol());
   			return false;
   		}
	}
	else	$strSymbol = $sym->GetSymbol();

	$strStockId = SqlGetStockId($strSymbol);
	$his_sql = GetStockHistorySql();
	$strDate = $his_sql->GetDateNow($strStockId);
	$strNavDate = UseSameDayNav($sym) ? $strDate : $his_sql->GetDatePrev($strStockId, $strDate);
	if (SqlGetNavByDate($strStockId, $strNavDate))		return false;
//	else													DebugString('SinaFundNeedFile need nav on '.$strNavDate.' '.$strSymbol);

    $sym->SetTimeZone();
    $now_ymd = new NowYMD();
   	if (($now_ymd->GetYMD() == $strDate) && $now_ymd->GetHourMinute() < 1600)
   	{
 		DebugString($strSymbol.': Market not closed');
   		return false;
    }

	return $now_ymd->NeedFile($strFileName, 30 * SECONDS_IN_MIN);
}

function StockNeedNewQuotes($sym, $strFileName, $iInterval = SECONDS_IN_MIN)
{
	clearstatcache(true, $strFileName);
	if (file_exists($strFileName) == false)	return true;

	$sym->SetTimeZone();
    $now_ymd = new NowYMD();
	if (($iFileTime = $now_ymd->NeedFile($strFileName, $iInterval)) == false)		return false;	// update on every minute
	
	if ($now_ymd->GetTick() > ($iFileTime + 6 * SECONDS_IN_HOUR))						return true;	// always update after 6 hours
	if ($sym->IsMarketTrading($now_ymd))													return true;
	if ($sym->IsMarketTrading(new TickYMD($iFileTime)))								return true;
	
    return false;
}

function ForexAndFutureNeedNewFile($strFileName, $strTimeZone, $iInterval = SECONDS_IN_MIN)
{
    date_default_timezone_set($strTimeZone);
    clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $ymd = new NowYMD();
        if ($ymd->NeedFile($strFileName, $iInterval) == false)       return false;   // update on every minute
        
        $file_ymd = new TickYMD(filemtime($strFileName));
        if ($file_ymd->IsWeekDay())    return true;
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

function _prefetchSinaData($arSym)
{
    $strSymbols = '';
    $arFileName = array();
    
    foreach ($arSym as $str => $sym)
    {
        $strFileName = DebugGetSinaFileName($str);
		if ($sym->IsSinaFund())
        {   // fund, IsSinaFund must be called before IsSinaFuture
			if (SinaFundNeedFile($sym, $strFileName) == false)		continue;
//            if (IsNewDailyQuotes($sym, $strFileName, '_GetFundQuotesYMD'))       continue;
        }
        else if ($sym->IsSinaFuture() || $sym->IsSinaForex())
        {   // forex and future
            if (ForexAndFutureNeedNewFile($strFileName, ForexAndFutureGetTimezone(), PREFETCH_INTERVAL) == false)    continue;
        }
        else
        {   // Stock symbol
            if (StockNeedNewQuotes($sym, $strFileName, PREFETCH_INTERVAL) == false)  continue;
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
            {  	// IsSinaFund must be called before IsSinaFuture
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
