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
	$strFileName = DebugGetYahooFileName($strSymbol);
	if (StockNeedFile($strFileName) == false)	return false; 	// updates on every minute

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

/*
Array
(
    [chart] => Array
        (
            [result] => Array
                (
                    [0] => Array
                        (
                            [meta] => Array
                                (
                                    [currency] => USD
                                    [symbol] => AAPL
                                    [exchangeName] => NMS
                                    [fullExchangeName] => NasdaqGS
                                    [instrumentType] => EQUITY
                                    [firstTradeDate] => 345479400
                                    [regularMarketTime] => 1727467204
                                    [hasPrePostMarketData] => 1
                                    [gmtoffset] => -14400
                                    [timezone] => EDT
                                    [exchangeTimezoneName] => America/New_York
                                    [regularMarketPrice] => 227.79
                                    [fiftyTwoWeekHigh] => 229.52
                                    [fiftyTwoWeekLow] => 227.3
                                    [regularMarketDayHigh] => 229.52
                                    [regularMarketDayLow] => 227.3
                                    [regularMarketVolume] => 33706549
                                    [longName] => Apple Inc.
                                    [shortName] => Apple Inc.
                                    [chartPreviousClose] => 228.2
                                    [priceHint] => 2
                                    [currentTradingPeriod] => Array
                                        (
                                            [pre] => Array
                                                (
                                                    [timezone] => EDT
                                                    [start] => 1727424000
                                                    [end] => 1727443800
                                                    [gmtoffset] => -14400
                                                )

                                            [regular] => Array
                                                (
                                                    [timezone] => EDT
                                                    [start] => 1727443800
                                                    [end] => 1727467200
                                                    [gmtoffset] => -14400
                                                )

                                            [post] => Array
                                                (
                                                    [timezone] => EDT
                                                    [start] => 1727467200
                                                    [end] => 1727481600
                                                    [gmtoffset] => -14400
                                                )
                                        )
                                    [dataGranularity] => 1d
                                    [range] => 5d
                                    [validRanges] => Array
                                        (
                                            [0] => 1d
                                            [1] => 5d
                                            [2] => 1mo
                                            [3] => 3mo
                                            [4] => 6mo
                                            [5] => 1y
                                            [6] => 2y
                                            [7] => 5y
                                            [8] => 10y
                                            [9] => ytd
                                            [10] => max
                                        )
                                )
                            [timestamp] => Array
                                (
                                    [0] => 1727098200
                                    [1] => 1727184600
                                    [2] => 1727271000
                                    [3] => 1727357400
                                    [4] => 1727443800
                                )
                            [indicators] => Array
                                (
                                    [quote] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [low] => Array
                                                        (
                                                            [0] => 225.80999755859
                                                            [1] => 225.72999572754
                                                            [2] => 224.02000427246
                                                            [3] => 225.41000366211
                                                            [4] => 227.30000305176
                                                        )
                                                    [volume] => Array
                                                        (
                                                            [0] => 54146000
                                                            [1] => 43556100
                                                            [2] => 42308700
                                                            [3] => 36636700
                                                            [4] => 33993600
                                                        )
                                                    [open] => Array
                                                        (
                                                            [0] => 227.33999633789
                                                            [1] => 228.64999389648
                                                            [2] => 224.92999267578
                                                            [3] => 227.30000305176
                                                            [4] => 228.46000671387
                                                        )
                                                    [high] => Array
                                                        (
                                                            [0] => 229.44999694824
                                                            [1] => 229.35000610352
                                                            [2] => 227.28999328613
                                                            [3] => 228.5
                                                            [4] => 229.52000427246
                                                        )
                                                    [close] => Array
                                                        (
                                                            [0] => 226.4700012207
                                                            [1] => 227.36999511719
                                                            [2] => 226.36999511719
                                                            [3] => 227.52000427246
                                                            [4] => 227.78999328613
                                                        )
                                                )
                                        )
                                    [adjclose] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [adjclose] => Array
                                                        (
                                                            [0] => 226.4700012207
                                                            [1] => 227.36999511719
                                                            [2] => 226.36999511719
                                                            [3] => 227.52000427246
                                                            [4] => 227.78999328613
                                                        )
                                                )
                                        )
                                )
                        )
                )
            [error] => 
        )
)*/

// https://query1.finance.yahoo.com/v7/finance/chart/AAPL?range=2y&interval=1d&indicators=quote&includeTimestamps=true
function UpdateYahooHistoryChart($ref)
{
	$strStockId = $ref->GetStockId();
	$strCurDate = $ref->GetDate();
   	$date_sql = new StockHistoryDateSql();
   	if ($strCurDate == $date_sql->ReadDate($strStockId))		return false;
	
	$ref->SetTimeZone();
//	$strSymbol = $ref->GetSymbol();
	$strYahooSymbol = $ref->GetYahooSymbol();
	$strFileName = DebugGetYahooFileName($strYahooSymbol.'Chart');
	if (StockNeedFile($strFileName) == false)	return false; 	// updates on every minute

	$strUrl = GetYahooDataUrl('7')."/chart/$strYahooSymbol?range=2y&interval=1d&indicators=quote&includeTimestamps=true";
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString($strUrl.' save new file to '.$strFileName);
   		file_put_contents($strFileName, $str);
   		$ar = json_decode($str, true);
		if (!isset($ar['chart']))			
		{
			DebugString('no chart');
			return false;
		}
		
		$arChart = $ar['chart'];
		if (!isset($arChart['result']))
		{
			DebugString('no chart result');
			return false;
		}

		$arResult = $arChart['result'][0];
		if (!isset($arResult['timestamp']))
		{
			DebugString('no chart result 0 timestamp');
			return false;
		}
		
   		$arTimeStamp = $arResult['timestamp'];
   		$arIndicators = $arResult['indicators'];
		if (!isset($arIndicators['quote']))
		{
			DebugString('no chart result 0 indicators quote');
			return false;
		}
		if (!isset($arIndicators['adjclose']))
		{
			DebugString('no chart result 0 indicators adjclose');
			return false;
		}
		
		$arLow = $arIndicators['quote'][0]['low'];
		$arVolume = $arIndicators['quote'][0]['volume'];
		$arOpen = $arIndicators['quote'][0]['open'];
		$arHigh = $arIndicators['quote'][0]['high'];
		$arClose = $arIndicators['quote'][0]['close'];
		$arAdjClose = $arIndicators['adjclose'][0]['adjclose'];

        $his_sql = GetStockHistorySql();
        $oldest_ymd = new OldestYMD();
        $iTotal = 0;
        $iModified = 0;
        $strLastDate = '';
		for ($i = 0; $i < count($arTimeStamp); $i ++)
		{
    		$ymd = new TickYMD(intval($arTimeStamp[$i]));
    		$strDate = $ymd->GetYMD();
    		if ($oldest_ymd->IsTooOld($strDate))	continue;
    		if ($strDate == $strLastDate)			continue;	// future have continue data 23 hours a day
    		$strLastDate = $strDate; 
    		
    		$strOpen = mysql_round($arOpen[$i]);
    		$strHigh = mysql_round($arHigh[$i]);
    		$strLow = mysql_round($arLow[$i]);
    		$strClose = $arClose[$i];
    		$strVolume = $arVolume[$i];
    		$strAdjClose = mysql_round($arAdjClose[$i]);

	        if ($strClose == '-' || $strClose == 'null' || IsZeroString($strClose))
	        {
	        	DebugString('Empty data: '.$strDate.' '.$strOpen.' '.$strHigh.' '.$strLow.' '.$strClose.' '.$strVolume.' '.$strAdjClose);		// debug wrong data
	        	continue;
	        }
	        $strClose = mysql_round($strClose);
	        
	        if (IsZeroString($strVolume))
	        {
//	        	if (($strClose == $strOpen) && ($strClose == $strHigh) && ($strClose == $strLow))
//	        	{
	        		DebugString('Holiday: '.$strDate.' '.$strOpen.' '.$strHigh.' '.$strLow.' '.$strClose.' '.$strVolume.' '.$strAdjClose);
	        		continue;
//	        	}
	        }
	        if ($oldest_ymd->IsInvalid($strDate) == false)
	        {
	        	$iTotal ++;
	        	if ($his_sql->WriteHistory($strStockId, $strDate, $strClose, $strOpen, $strHigh, $strLow, $strVolume, $strAdjClose))
	        	{
	        		$iModified ++;
	        	}
	        }
		}
		
		DebugVal($iTotal, 'Total');
		DebugVal($iModified, 'Modified');
//		if ($ref->IsSymbolA() || $ref->IsSymbolH())
//		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
			$his_sql->DeleteByZeroVolume($strStockId);
//		}
		$date_sql->WriteDate($strStockId, $strCurDate);
		return true;
   	}
    return false;
}

?>
