<?php
define('PREFETCH_INTERVAL', (SECONDS_IN_MIN - 10));

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
// 		DebugString($strSymbol.': Market not closed');
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
	if ($sym->IsMarketTrading(new TickYMD($iFileTime)))								return true;
	if ($sym->IsMarketTrading($now_ymd))													return true;
	
    return false;
}

function ForexAndFutureNeedNewFile($strFileName, $strTimeZone, $iInterval = SECONDS_IN_MIN)
{
	clearstatcache(true, $strFileName);
	if (file_exists($strFileName) == false)	return true;

    date_default_timezone_set($strTimeZone);
	$now_ymd = new NowYMD();
	if (($iFileTime = $now_ymd->NeedFile($strFileName, $iInterval)) == false)		return false;	// update on every minute
        
	$file_ymd = new TickYMD($iFileTime);
    if ($file_ymd->IsWeekDay())    														return true;
	if ($now_ymd->IsWeekDay())    														return true;

	return false;
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
