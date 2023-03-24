<?php

/*
Array
(
    [quoteResponse] => Array
        (
            [result] => Array
                (
                    [0] => Array
                        (
                            [language] => en-US
                            [region] => US
                            [quoteType] => INDEX
                            [typeDisp] => Index
                            [quoteSourceName] => Delayed Quote
                            [triggerable] => 1
                            [customPriceAlertConfidence] => HIGH
                            [askSize] => 0
                            [fullExchangeName] => NYSE American
                            [regularMarketOpen] => 120.2662
                            [fiftyTwoWeekLowChange] => 1.6408005
                            [fiftyTwoWeekLowChangePercent] => 0.013643073
                            [fiftyTwoWeekRange] => 120.2662 - 122.844
                            [fiftyTwoWeekHighChange] => -0.9370041
                            [fiftyTwoWeekHighChangePercent] => -0.0076275934
                            [fiftyTwoWeekLow] => 120.2662
                            [fiftyTwoWeekHigh] => 122.844
                            [sourceInterval] => 15
                            [exchangeDataDelayedBy] => 0
                            [tradeable] => 
                            [cryptoTradeable] => 
                            [currency] => USD
                            [marketState] => REGULAR
                            [exchange] => ASE
                            [shortName] => SPDR S&P Oil  and  Gas Explorat
                            [longName] => SPDR S&P Oil  and  Gas Explorat
                            [messageBoardId] => finmb_INDEXXOP-IV
                            [exchangeTimezoneName] => America/New_York
                            [exchangeTimezoneShortName] => EDT
                            [gmtOffSetMilliseconds] => -14400000
                            [market] => us_market
                            [esgPopulated] => 
                            [regularMarketChangePercent] => 1.3648925
                            [regularMarketPrice] => 121.907
                            [priceHint] => 2
                            [regularMarketChange] => 1.6414948
                            [regularMarketTime] => 1679586690
                            [regularMarketDayHigh] => 122.844
                            [regularMarketDayRange] => 120.2662 - 122.844
                            [regularMarketDayLow] => 120.2662
                            [regularMarketVolume] => 0
                            [regularMarketPreviousClose] => 120.2655
                            [bid] => 0
                            [ask] => 0
                            [bidSize] => 0
                            [symbol] => ^XOP-IV
                        )

                )

            [error] => 
        )
)*/

function _yahooStockGetData($strSymbol, $strStockId)
{ 
    $now_ymd = GetNowYMD();
	$strFileName = DebugGetYahooFileName($strSymbol);
   	clearstatcache(true, $strFileName);
   	if (file_exists($strFileName))
   	{
   		if ($now_ymd->NeedFile($strFileName, SECONDS_IN_MIN) == false)		return false;
   	}
   	
	$strUrl = GetYahooQuotesUrl().'/quote?symbols='.$strSymbol;
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString($strFileName.': Save new file');
   		file_put_contents($strFileName, $str);
   		$ar = json_decode($str, true);
//   		DebugPrint($ar);
   		$arData = $ar['quoteResponse']['result'][0];
		$ymd = new TickYMD($arData['regularMarketTime']);
		$strDate = $now_ymd->GetYMD();
		if ($ymd->GetYMD() == $strDate)
		{
			$strNav = $arData['regularMarketPrice'];
			$nav_sql = GetNavHistorySql();
			$nav_sql->InsertDaily($strStockId, $strDate, $strNav);
			DebugString('Update NAV for '.$arData['symbol'].' '.$strDate.' '.$strNav);
			return array($strNav, $strDate);
		}
   	}
    return false;
}

// force update, no any condition checking as in YahooUpdateNetValue
function YahooGetNetValue($ref)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
    $strSymbol = $ref->GetSymbol();
	return _yahooStockGetData(($ref->IsIndex() ? $strSymbol : GetYahooNetValueSymbol($strSymbol)), $ref->GetStockId());
}

function _yahooGetNetValueSymbol($sym, $strSymbol)
{
    if ($sym->IsSinaFuture())
    {
    	return false;
    }
    else if ($sym->IsSymbolA() || $sym->IsSymbolH())
    {
    	return false;
    }
    else if ($sym->IsIndex())
    {
//   		return $strSymbol;
    	return false;
   	}
   	else
   	{
   		switch ($strSymbol)
   		{
//   		case 'GSG':
   		case 'IBB':
   		case 'KWEB':
   		case 'QQQ':
   		case 'SCHH':
   		case 'USO':
   			return false;
   		}
   	}
   	return GetYahooNetValueSymbol($strSymbol);
}

function YahooUpdateNetValue($ref)
{
	if ($ref->HasData() == false)	return;
	
	$strSymbol = $ref->GetSymbol();
	if (($strNetValueSymbol = _yahooGetNetValueSymbol($ref, $strSymbol)) === false)		return;
	
    date_default_timezone_set(STOCK_TIME_ZONE_US);
	$nav_sql = GetNavHistorySql();
	$strStockId = $ref->GetStockId();
	$strDate = $ref->GetDate();
    if ($nav_sql->GetRecord($strStockId, $strDate))	return;	// already have today's data
	
    $now_ymd = GetNowYMD();
   	if (($now_ymd->GetYMD() == $strDate) && $now_ymd->GetHourMinute() < 1655)
   	{
// 		DebugString($strSymbol.': Market not closed');
   		return;
    }

    _yahooStockGetData($strNetValueSymbol, $strStockId);    
}

?>
