<?php
require_once('../../php/stockhis.php');

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
	$ref->SetTimeZone();
	$strStockId = $ref->GetStockId();
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
		
   		$arTimeStamp = $arChart['result'][0]['timestamp'];
   		$arIndicators = $arChart['result'][0]['indicators'];
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
    		
    		$strOpen = $arOpen[$i];
    		$strHigh = $arHigh[$i];
    		$strLow = $arLow[$i];
    		$strClose = $arClose[$i];
    		$strVolume = $arVolume[$i];
    		$strAdjClose = $arAdjClose[$i];

	        if ($strClose == '-' || $strClose == 'null')
	        {
	        	DebugString($strDate.' '.$strOpen.' '.$strHigh.' '.$strLow.' '.$strClose.' '.$strVolume.' '.$strAdjClose);		// debug wrong data
	        	continue;
	        }
	        if ($strVolume == '0')
	        {
	        	if (($strClose == $strOpen) && ($strClose == $strHigh) && ($strClose == $strLow))
	        	{
	        		DebugString('Holiday: '.$strDate.' '.$strClose);
	        		continue;
	        	}
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
		return true;
   	}
    return false;
}

?>
