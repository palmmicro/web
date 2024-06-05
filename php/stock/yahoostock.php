<?php

/*
// https://query2.finance.yahoo.com/v7/finance/quote?symbols=%5ESPY-IV&formatted=true&crumb=xixceA79ORo&lang=en-US&region=US&corsDomain=finance.yahoo.com&fields=exchangeTimezoneName%2CexchangeTimezoneShortName%2CregularMarketTime%2CgmtOffSetMilliseconds
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

/*
// https://query1.finance.yahoo.com/v7/finance/options/XOP
Array
(
    [optionChain] => Array
        (
            [result] => Array
                (
                    [0] => Array
                        (
                            [underlyingSymbol] => ^ASHR-IV
                            [expirationDates] => Array
                                (
                                )

                            [strikes] => Array
                                (
                                )

                            [hasMiniOptions] => 
                            [quote] => Array
                                (
                                    [language] => en-US
                                    [region] => US
                                    [quoteType] => INDEX
                                    [typeDisp] => Index
                                    [quoteSourceName] => Delayed Quote
                                    [triggerable] => 1
                                    [customPriceAlertConfidence] => HIGH
                                    [currency] => USD
                                    [exchange] => ASE
                                    [shortName] => Xtrackers Harvest CSI 300 China
                                    [longName] => Xtrackers Harvest CSI 300 China
                                    [messageBoardId] => finmb_INDEXASHR-IV
                                    [exchangeTimezoneName] => America/New_York
                                    [exchangeTimezoneShortName] => EDT
                                    [market] => us_market
                                    [regularMarketChangePercent] => 0.35430536
                                    [regularMarketPrice] => 27.3611
                                    [gmtOffSetMilliseconds] => -14400000
                                    [esgPopulated] => 
                                    [regularMarketChange] => 0.09659958
                                    [regularMarketTime] => 1685131485
                                    [priceHint] => 2
                                    [regularMarketDayHigh] => 27.3783
                                    [regularMarketDayRange] => 27.3515 - 27.3783
                                    [regularMarketDayLow] => 27.3515
                                    [regularMarketVolume] => 0
                                    [regularMarketPreviousClose] => 27.2645
                                    [bid] => 0
                                    [ask] => 0
                                    [bidSize] => 0
                                    [askSize] => 0
                                    [fullExchangeName] => NYSE American
                                    [regularMarketOpen] => 27.3618
                                    [fiftyTwoWeekLowChange] => 0.009599686
                                    [fiftyTwoWeekLowChangePercent] => 0.00035097476
                                    [fiftyTwoWeekRange] => 27.3515 - 27.3783
                                    [fiftyTwoWeekHighChange] => -0.01720047
                                    [fiftyTwoWeekHighChangePercent] => -0.00062825193
                                    [fiftyTwoWeekLow] => 27.3515
                                    [fiftyTwoWeekHigh] => 27.3783
                                    [sourceInterval] => 15
                                    [exchangeDataDelayedBy] => 0
                                    [tradeable] => 
                                    [cryptoTradeable] => 
                                    [marketState] => POST
                                    [symbol] => ^ASHR-IV
                                )

                            [options] => Array
                                (
                                )

                        )

                )

            [error] => 
        )

)
*/
function _yahooStockGetData($strSymbol, $strStockId)
{ 
    $now_ymd = GetNowYMD();
	$strFileName = DebugGetYahooFileName($strSymbol);
   	clearstatcache(true, $strFileName);
   	if (file_exists($strFileName))
   	{
   		if ($now_ymd->NeedFile($strFileName, SECONDS_IN_MIN) == false)		return false;
   	}
   	
//	$strUrl = GetYahooDataUrl().'/quote?symbols='.$strSymbol;
	$strUrl = GetYahooDataUrl().'/options/'.$strSymbol;
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString($strUrl.' save new file to '.$strFileName);
   		file_put_contents($strFileName, $str);
   		$ar = json_decode($str, true);
//   		DebugPrint($ar);
//		if (!isset($ar['quoteResponse']))			
		if (!isset($ar['optionChain']))			
		{
			DebugString('no quoteResponse');
//			DebugPrint($ar);
			return false;
		}
//		$arQuoteResponse = $ar['quoteResponse'];
		$arQuoteResponse = $ar['optionChain'];
		if (!isset($arQuoteResponse['result']))
		{
			DebugString('no quoteResponse result');
			return false;
		}
		
//   		$arData = $arQuoteResponse['result'][0];
   		$arData = $arQuoteResponse['result'][0]['quote'];
		if (!isset($arData['regularMarketTime']))
		{
			DebugString('no quoteResponse result 0 regularMarketTime');
			return false;
		}
		
		$ymd = new TickYMD($arData['regularMarketTime']);
		$strDate = $ymd->GetYMD();
		if (!isset($arData['regularMarketPrice']))
		{
			DebugString('no quoteResponse result 0 regularMarketPrice');
			return false;
		}
		$strNav = $arData['regularMarketPrice'];
		$nav_sql = GetNavHistorySql();
		if ($nav_sql->WriteDaily($strStockId, $strDate, $strNav))
		{
			DebugString('Update NAV for '.$arData['symbol'].' '.$strDate.' '.$strNav);
			return array($strNav, $strDate);
		}
   	}
    return false;
}

// force update, no any condition checking as in YahooUpdateNetValue
function YahooGetNetValue($ref)
{
//	date_default_timezone_set('America/New_York');
	$ref->SetTimeZone();
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
    else if ($sym->IsIndex() || $sym->IsSinaGlobalIndex())
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
	
//    date_default_timezone_set('America/New_York');
	$ref->SetTimeZone();
	$nav_sql = GetNavHistorySql();
	$strStockId = $ref->GetStockId();
	$strDate = $ref->GetDate();
    if ($nav_sql->GetRecord($strStockId, $strDate))	return;	// already have today's data
	
    $now_ymd = GetNowYMD();
    $iHourMinute = $now_ymd->GetHourMinute();
   	if ($now_ymd->GetYMD() == $strDate)
   	{
   		if ($iHourMinute < 1655)
   		{
//   			DebugString($strSymbol.': Market not closed');
   			return;
   		}
    }
/*    else
    {
   		if ($iHourMinute > 900)
   		{
   			DebugString($strSymbol.': a trading day has begun');
   			return;
   		}
    }
*/
	return _yahooStockGetData($strNetValueSymbol, $strStockId);    
}

?>
