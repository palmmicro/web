<?php

// https://finance.yahoo.com/quote/XOP/history?period1=1467122442&period2=1498658442&interval=1d&filter=history&frequency=1d 
define('YAHOO_STOCK_QUOTES_URL', 'https://finance.yahoo.com/quote/');
function YahooStockHistoryGetUrl($strYahooSymbol, $iTimeBegin = false, $iTimeEnd = false)
{
    $strUrl = YAHOO_STOCK_QUOTES_URL.$strYahooSymbol.'/history';
    if ($iTimeBegin && $iTimeEnd)
    {
    	$strUrl .= '?period1='.strval($iTimeBegin).'&period2='.strval($iTimeEnd).'&interval=1d&filter=history&frequency=1d';
    }
    return $strUrl;
}

function YahooGetStockHistory($strYahooSymbol, $iTimeBegin, $iTimeEnd)
{
    $strUrl = YahooStockHistoryGetUrl($strYahooSymbol, $iTimeBegin, $iTimeEnd);
//    DebugString($strUrl);
    return url_get_contents($strUrl); 
}

/*
<td class="Py(10px) Ta(start) Pend(10px)" data-reactid="52"><span data-reactid="53">Dec 15, 2017</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="54"><span data-reactid="55">34.78</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="56"><span data-reactid="57">34.69</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="58"><span data-reactid="59">34.05</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="60"><span data-reactid="61">34.13</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="62"><span data-reactid="63">34.13</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="64"><span data-reactid="65">11,759,579</span></td>
</tr>
*/

function preg_match_yahoo_history($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Ta\(start\) Pend\(10px\)" data-reactid="\d*"><span data-reactid="\d*">', '[^<]*', '</span></td>');
    for ($i = 0; $i < 6; $i ++)
    {
        $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Pstart\(10px\)" data-reactid="\d*">'.RegExpSkip('<span data-reactid="\d*">'), '[^<]*', RegExpSkip('</span>').'</td>');
    }
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

/*
"^SPSIOP":{
"sourceInterval":15,
"regularMarketOpen":{"raw":5937.12,"fmt":"5,937.12"},
"exchange":"SNP",
"regularMarketTime":{"raw":1524256852,"fmt":"4:40PM EDT"},
"fiftyTwoWeekRange":{"raw":"5846.45 - 5946.23","fmt":"5,846.45 - 5,946.23"},
"regularMarketDayHigh":{"raw":5946.23,"fmt":"5,946.23"},
"shortName":"S&P Oil & Gas Exploration & Pro",
"exchangeTimezoneName":"America\u002FNew_York",
"regularMarketChange":{"raw":-35.29004,"fmt":"-35.29"},
"regularMarketPreviousClose":{"raw":5937.12,"fmt":"5,937.12"},
"fiftyTwoWeekHighChange":{"raw":-31.399902,"fmt":"-31.40"},
"exchangeTimezoneShortName":"EDT",
"fiftyTwoWeekLowChange":{"raw":68.37988,"fmt":"68.38"},
"exchangeDataDelayedBy":0,
"regularMarketDayLow":{"raw":5846.45,"fmt":"5,846.45"},
"priceHint":2,
"currency":"USD",
"regularMarketPrice":{"raw":5914.83,"fmt":"5,914.83"},
"regularMarketVolume":{"raw":0,"fmt":"0","longFmt":"0"},
"isLoading":false,
"gmtOffSetMilliseconds":-14400000,
"marketState":"CLOSED",
"quoteType":"INDEX",
"invalid":false,
"symbol":"^SPSIOP",
"language":"en-US",
"fiftyTwoWeekLowChangePercent":{"raw":0.011695966,"fmt":"1.17%"},
"regularMarketDayRange":{"raw":"5846.45 - 5946.23","fmt":"5,846.45 - 5,946.23"},
"messageBoardId":"finmb_INDEXSPSIOP",
"fiftyTwoWeekHigh":{"raw":5946.23,"fmt":"5,946.23"},
"fiftyTwoWeekHighChangePercent":{"raw":-0.0052806404,"fmt":"-0.53%"},
"market":"us_market",
"fiftyTwoWeekLow":{"raw":5846.45,"fmt":"5,846.45"},
"regularMarketChangePercent":{"raw":-0.5930979,"fmt":"-0.59%"},
"fullExchangeName":"SNP",
"tradeable":false
},

"^XOP-IV":{
"sourceInterval":15,
"quoteSourceName":"Delayed Quote",
"regularMarketOpen":{"raw":38.9737,"fmt":"38.9737"},
"exchange":"ASE",
"regularMarketTime":{"raw":1524256191,"fmt":"4:29PM EDT"},
"fiftyTwoWeekRange":{"raw":"38.3903 - 39.0376","fmt":"38.39 - 39.04"},
"regularMarketDayHigh":{"raw":39.0376,"fmt":"39.0376"},
"shortName":"SPDR S&P Oil & Gas Exploration ",
"exchangeTimezoneName":"America\u002FNew_York",
"regularMarketChange":{"raw":-0.14630127,"fmt":"-0.1463"},
"regularMarketPreviousClose":{"raw":38.9784,"fmt":"38.9784"},
"fiftyTwoWeekHighChange":{"raw":-0.20550156,"fmt":"-0.21"},
"exchangeTimezoneShortName":"EDT",
"fiftyTwoWeekLowChange":{"raw":0.44179916,"fmt":"0.44"},
"exchangeDataDelayedBy":0,
"regularMarketDayLow":{"raw":38.3903,"fmt":"38.3903"},
"priceHint":4,
"currency":"USD",
"regularMarketPrice":{"raw":38.8321,"fmt":"38.8321"},
"regularMarketVolume":{"raw":0,"fmt":"0","longFmt":"0"},
"isLoading":false,
"gmtOffSetMilliseconds":-14400000,
"marketState":"REGULAR",
"quoteType":"INDEX",
"invalid":false,
"symbol":"^XOP-IV",
"language":"en-US",
"fiftyTwoWeekLowChangePercent":{"raw":0.011508093,"fmt":"1.15%"},
"regularMarketDayRange":{"raw":"38.3903 - 39.0376","fmt":"38.39 - 39.04"},
"messageBoardId":"finmb_INDEXXOP-IV",
"fiftyTwoWeekHigh":{"raw":39.0376,"fmt":"39.0376"},
"fiftyTwoWeekHighChangePercent":{"raw":-0.005264195,"fmt":"-0.53%"},
"market":"us_market",
"fiftyTwoWeekLow":{"raw":38.3903,"fmt":"38.3903"},
"regularMarketChangePercent":{"raw":-0.37533933,"fmt":"-0.3753%"},
"fullExchangeName":"NYSE American",
"tradeable":false
}
*/

function _preg_match_yahoo_stock($str)
{
    $strBoundary = RegExpBoundary();
//    $strSymbol = RegExpStockSymbol($strSymbol);
    $strAll = RegExpAll();
    
    $strPattern = $strBoundary;
//    $strPattern .= '"'.$strSymbol.'":{"'.$strAll;
    $strPattern .= RegExpParenthesis('"regularMarketTime":{"raw":', RegExpDigit(), ',"fmt":"');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('"regularMarketChange":{"raw":', RegExpNumber(), ',"fmt":"');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('"regularMarketPrice":{"raw":', RegExpNumber(), ',"fmt":"');
  	$strPattern .= $strAll;
   	$strPattern .= RegExpParenthesis('"symbol":"', '[^"]*', '",');
//   	$strPattern .= '"symbol":"'.$strSymbol;
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    if (RegExpDebug($arMatch, 'Yahoo stock', 17) == 0)	return false;
    return $arMatch;
}

function _yahooStockMatchGetYmd($arMatch, $strSymbol)
{
	foreach ($arMatch as $ar)
	{
		if ($ar[4] == $strSymbol)
		{
			return new TickYMD($ar[1]);
		}
	}
   	return false;
}

function _yahooStockMatchGetDate($arMatch, $strSymbol)
{
	if ($ymd = _yahooStockMatchGetYmd($arMatch, $strSymbol))
	{
		return $ymd->GetYMD();
	}
   	return false;
}

function YahooStockGetUrl($strYahooSymbol)
{
	return YAHOO_STOCK_QUOTES_URL.$strYahooSymbol;
}

function _yahooStockGetData($strSymbol, $strStockId)
{ 
	$sym = new StockSymbol($strSymbol);
    $strUrl = YahooStockGetUrl($sym->GetYahooSymbol());
    if ($str = url_get_contents($strUrl))
    {
    	if ($arMatch = _preg_match_yahoo_stock($str))
    	{
    		foreach ($arMatch as $ar)
    		{
    			if ($ar[4] == $strSymbol)
    			{
    				$strMatchPrice = $ar[3];
    				$ymd = new TickYMD($ar[1]);
    				$strDate = $ymd->GetYMD();
    				$sql = new NetValueHistorySql($strStockId);
    				$sql->Write($strDate, $strMatchPrice);
    				return $strMatchPrice.' '.$ar[2].' '.$strDate.' '.$ymd->GetHMS();
    			}
    		}
    	}
    }
    return false;
}

function YahooGetWebData($ref)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
    $strSymbol = $ref->GetSymbol();
    $strStockId = $ref->GetStockId();
    if ($ref->IsIndex())
    {
   		$str = _yahooStockGetData($strSymbol, $strStockId);
   	}
   	else
   	{
   		$str = _yahooStockGetData(GetYahooNetValueSymbol($strSymbol), $strStockId);
   	}
   	return $str;
}

function _getNetValueDelayTick()
{	// get net value after 16:55
	return 16 * SECONDS_IN_HOUR + 55 * SECONDS_IN_MIN;
}

function _yahooNetValueHasFile($now_ymd, $strFileName, $strNetValueSymbol)
{
	clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        $arMatch = _preg_match_yahoo_stock($str);
        if ($now_ymd->IsNewFile($strFileName))														return $arMatch;   		// update on every minute
        
        if ($arMatch)
        {
        	$strDate = _yahooStockMatchGetDate($arMatch, $strNetValueSymbol);
        	$ymd = new StringYMD($strDate);
        	if (($ymd->GetNextTradingDayTick() + _getNetValueDelayTick()) <= $now_ymd->GetTick())	return false;		// need update
        }
        else
        {
        	return false;
        }

//        DebugString($strFileName.' - Use current file');
        return $arMatch;
    }
    return false;
}

function _yahooGetNetValueSymbol($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
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
   		return $strSymbol;
   	}
   	else
   	{
   		if ($strSymbol == 'USO' || $strSymbol == 'GSG')	return false;
   	}
   	return GetYahooNetValueSymbol($strSymbol);
}

function YahooUpdateNetValue($strSymbol)
{
	if (($strNetValueSymbol = _yahooGetNetValueSymbol($strSymbol)) == false)	return;
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  					return;
	$sql = new NetValueHistorySql($strStockId);
	
    date_default_timezone_set(STOCK_TIME_ZONE_US);
    $now_ymd = new NowYMD();
    $strDate = $now_ymd->GetYMD();
    if ($sql->GetRecord($strDate))								return;
    if ($now_ymd->IsTradingDay())
    {
    	if ($now_ymd->GetTick() < (strtotime($strDate) + _getNetValueDelayTick()))
    	{
//    		DebugString($strSymbol.': Market not closed');
    		return;
    	}
    }
    
	$strFileName = DebugGetYahooWebFileName($strSymbol);
	$arMatch = _yahooNetValueHasFile($now_ymd, $strFileName, $strNetValueSymbol);
    if ($arMatch == false)
    {
    	$sym = new StockSymbol($strNetValueSymbol);
    	$strUrl = YahooStockGetUrl($sym->GetYahooSymbol());
    	if ($str = url_get_contents($strUrl))
    	{
    		DebugString($strFileName.': Save new file');
    		file_put_contents($strFileName, $str);
    		$arMatch = _preg_match_yahoo_stock($str);
    	}
    	else
    	{
    		DebugString($strUrl.': No data!');
    		return;
    	}
    }
	
    if ($arMatch)
    {
    	$ymd = _yahooStockMatchGetYmd($arMatch, $strNetValueSymbol);
    	$strDate = $ymd->GetYMD();
    	if ($sql->GetRecord($strDate))		return;
    	foreach ($arMatch as $ar)
    	{
    		$strMatchSymbol = $ar[4];
    		$strMatchPrice = $ar[3];
    		// $strMatchChange = $ar[2];
    		if ($strNetValueSymbol == $strMatchSymbol)
    		{
    			$sql->Insert($strDate, $strMatchPrice);
    			DebugString('YahooUpdateNetValue '.$strNetValueSymbol.' '.$strDate.' '.$strMatchPrice);
    		}
    		else if ($strExtraId = SqlGetStockId($strMatchSymbol))
    		{
    			$extra_sql = new NetValueHistorySql($strExtraId);
    			$extra_ymd = _yahooStockMatchGetYmd($arMatch, $strMatchSymbol);
    			$extra_sql->Insert($extra_ymd->GetYMD(), $strMatchPrice);
    		}
    	}
    }
}

// "components":{"components":["AAPL","CSCO","CVX","VZ","JPM","JNJ","MRK","PFE","UNH","MSFT","IBM","V","WBA","UTX","TRV","KO","NKE","MMM","GS","DOW","MCD","DIS","INTC","CAT","XOM","PG","AXP","HD","BA","WMT"],"maxAge":1}}
function YahooUpdateComponents($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsIndex() == false)	return false;

   	$strUrl = GetYahooComponentsUrl($sym->GetYahooSymbol());
    if ($str = url_get_contents($strUrl))
    {
    	if ($strBlock = PregMatchSquareBracket('"components":{"components":', $str))
    	{
    		return explode('","', trim($strBlock, '"'));
    	}
    }
    return false;
}

/*
"incomeStatementHistoryQuarterly":
{"incomeStatementHistory":[{
"researchDevelopment":{"raw":10938000000,"fmt":"10.94B","longFmt":"10,938,000,000"},
"effectOfAccountingCharges":{},
"incomeBeforeTax":{"raw":73563000000,"fmt":"73.56B","longFmt":"73,563,000,000"},
"minorityInterest":{"raw":117432000000,"fmt":"117.43B","longFmt":"117,432,000,000"},
"netIncome":{"raw":72591000000,"fmt":"72.59B","longFmt":"72,591,000,000"},
"sellingGeneralAdministrative":{"raw":18587000000,"fmt":"18.59B","longFmt":"18,587,000,000"},
"grossProfit":{"raw":53471000000,"fmt":"53.47B","longFmt":"53,471,000,000"},
"ebit":{"raw":20940000000,"fmt":"20.94B","longFmt":"20,940,000,000"},
"endDate":{"raw":1569801600,"fmt":"2019-09-30"},
"operatingIncome":{"raw":20940000000,"fmt":"20.94B","longFmt":"20,940,000,000"},
"otherOperatingExpenses":{},
"interestExpense":{"raw":-1360000000,"fmt":"-1.36B","longFmt":"-1,360,000,000"},
"extraordinaryItems":{},
"nonRecurring":{},
"otherItems":{},
"incomeTaxExpense":{"raw":2815000000,"fmt":"2.81B","longFmt":"2,815,000,000"},
"totalRevenue":{"raw":119017000000,"fmt":"119.02B","longFmt":"119,017,000,000"},
"totalOperatingExpenses":{"raw":98077000000,"fmt":"98.08B","longFmt":"98,077,000,000"},
"costOfRevenue":{"raw":65546000000,"fmt":"65.55B","longFmt":"65,546,000,000"},
"totalOtherIncomeExpenseNet":{"raw":52623000000,"fmt":"52.62B","longFmt":"52,623,000,000"},
"maxAge":1,
"discontinuedOperations":{},
"netIncomeFromContinuingOps":{"raw":70748000000,"fmt":"70.75B","longFmt":"70,748,000,000"},
"netIncomeApplicableToCommonShares":{"raw":72540000000,"fmt":"72.54B","longFmt":"72,540,000,000"}
}*/

/*
"balanceSheetHistoryQuarterly":
{"balanceSheetStatements":[{
"intangibleAssets":{"raw":66100000000,"fmt":"66.1B","longFmt":"66,100,000,000"},
"capitalSurplus":{"raw":246073000000,"fmt":"246.07B","longFmt":"246,073,000,000"},
"totalLiab":{"raw":439346000000,"fmt":"439.35B","longFmt":"439,346,000,000"},
"totalStockholderEquity":{"raw":602799000000,"fmt":"602.8B","longFmt":"602,799,000,000"},
"minorityInterest":{"raw":117432000000,"fmt":"117.43B","longFmt":"117,432,000,000"},
"otherCurrentLiab":{"raw":71690000000,"fmt":"71.69B","longFmt":"71,690,000,000"},
"totalAssets":{"raw":1159577000000,"fmt":"1.16T","longFmt":"1,159,577,000,000"},
"endDate":{"raw":1569801600,"fmt":"2019-09-30"},
"commonStock":{"raw":1000000,"fmt":"1M","longFmt":"1,000,000"},
"otherCurrentAssets":{"raw":94677000000,"fmt":"94.68B","longFmt":"94,677,000,000"},
"retainedEarnings":{"raw":356993000000,"fmt":"356.99B","longFmt":"356,993,000,000"},
"otherLiab":{"raw":73875000000,"fmt":"73.88B","longFmt":"73,875,000,000"},
"goodWill":{"raw":276633000000,"fmt":"276.63B","longFmt":"276,633,000,000"},
"treasuryStock":{"raw":-268000000,"fmt":"-268M","longFmt":"-268,000,000"},
"otherAssets":{"raw":49299000000,"fmt":"49.3B","longFmt":"49,299,000,000"},
"cash":{"raw":234177000000,"fmt":"234.18B","longFmt":"234,177,000,000"},
"totalCurrentLiabilities":{"raw":243949000000,"fmt":"243.95B","longFmt":"243,949,000,000"},
"shortLongTermDebt":{"raw":16019000000,"fmt":"16.02B","longFmt":"16,019,000,000"},
"otherStockholderEquity":{"raw":-268000000,"fmt":"-268M","longFmt":"-268,000,000"},
"propertyPlantEquipment":{"raw":100907000000,"fmt":"100.91B","longFmt":"100,907,000,000"},
"totalCurrentAssets":{"raw":335687000000,"fmt":"335.69B","longFmt":"335,687,000,000"},
"longTermInvestments":{"raw":330951000000,"fmt":"330.95B","longFmt":"330,951,000,000"},
"netTangibleAssets":{"raw":260066000000,"fmt":"260.07B","longFmt":"260,066,000,000"},
"shortTermInvestments":{"raw":6833000000,"fmt":"6.83B","longFmt":"6,833,000,000"},
"maxAge":1,
"longTermDebt":{"raw":121522000000,"fmt":"121.52B","longFmt":"121,522,000,000"}
}*/

/*
"cashflowStatementHistoryQuarterly":
{"cashflowStatements":[{
"investments":{"raw":-65965000000,"fmt":"-65.97B","longFmt":"-65,965,000,000"},
"changeToLiabilities":{"raw":8639000000,"fmt":"8.64B","longFmt":"8,639,000,000"},
"totalCashflowsFromInvestingActivities":{"raw":-151060000000,"fmt":"-151.06B","longFmt":"-151,060,000,000"},
"netBorrowings":{"raw":-4231000000,"fmt":"-4.23B","longFmt":"-4,231,000,000"},
"totalCashFromFinancingActivities":{"raw":-7392000000,"fmt":"-7.39B","longFmt":"-7,392,000,000"},
"changeToOperatingActivities":{"raw":20551000000,"fmt":"20.55B","longFmt":"20,551,000,000"},
"issuanceOfStock":{"raw":354000000,"fmt":"354M","longFmt":"354,000,000"},
"netIncome":{"raw":87886000000,"fmt":"87.89B","longFmt":"87,886,000,000"},
"changeInCash":{"raw":-4232000000,"fmt":"-4.23B","longFmt":"-4,232,000,000"},
"endDate":{"raw":1553990400,"fmt":"2019-03-31"},
"repurchaseOfStock":{"raw":-10872000000,"fmt":"-10.87B","longFmt":"-10,872,000,000"},
"effectOfExchangeRate":{"raw":3245000000,"fmt":"3.25B","longFmt":"3,245,000,000"},
"totalCashFromOperatingActivities":{"raw":150975000000,"fmt":"150.97B","longFmt":"150,975,000,000"},
"depreciation":{"raw":36936000000,"fmt":"36.94B","longFmt":"36,936,000,000"},
"otherCashflowsFromInvestingActivities":{"raw":-8000000,"fmt":"-8M","longFmt":"-8,000,000"},
"otherCashflowsFromFinancingActivities":{"raw":7357000000,"fmt":"7.36B","longFmt":"7,357,000,000"},
"maxAge":1,
"changeToNetincome":{"raw":-6241000000,"fmt":"-6.24B","longFmt":"-6,241,000,000"},
"capitalExpenditures":{"raw":-35482000000,"fmt":"-35.48B","longFmt":"-35,482,000,000"}
}
*/

function _preg_match_yahoo_financials($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('{"raw":'.RegExpNumber().',"fmt":"', RegExpFmtNumber(), '","longFmt":"');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function _preg_match_yahoo_financials_date($str)
{
    $strBoundary = RegExpBoundary();
    $strAll = RegExpAll();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('{"'.$strAll, RegExpDate(), $strAll.'"}}');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function _updateYahooFinancialsData(&$ar, $str, $strWhen, $strWhat)
{
	if ($strBlock = PregMatchSquareBracket('"'.$strWhen.'":{"'.$strWhat.'":', $str))
	{
		if ($arMatchDate = _preg_match_yahoo_financials_date($strBlock))
		{
			foreach ($arMatchDate as $arDate)
			{
				$strDate = $arDate[1];
//				DebugString($strWhen.' '.$strWhat.' '.$strDate);
				$arMatch = _preg_match_yahoo_financials($arDate[0]);
				foreach ($arMatch as $arVal)
				{
					$strVal = $arVal[1];
					if (isset($ar[$strDate]))	$ar[$strDate] .= ','.$strVal;
					else							$ar[$strDate] = $strVal;
				}
			}
		}
	}
}

function YahooUpdateFinancials($ref)
{
   	$strUrl = YahooStockGetUrl($ref->GetYahooSymbol()).'/financials';
    if ($str = url_get_contents($strUrl))
    {
    	$arAnnual = array();
    	_updateYahooFinancialsData(&$arAnnual, $str, 'incomeStatementHistory', 'incomeStatementHistory');
    	_updateYahooFinancialsData(&$arAnnual, $str, 'balanceSheetHistory', 'balanceSheetStatements');
    	_updateYahooFinancialsData(&$arAnnual, $str, 'cashflowStatementHistory', 'cashflowStatements');
//    	DebugArray($arAnnual);
		if (count($arAnnual) == 0)	return false;

    	$arQuarter = array();
    	_updateYahooFinancialsData(&$arQuarter, $str, 'incomeStatementHistoryQuarterly', 'incomeStatementHistory');
    	_updateYahooFinancialsData(&$arQuarter, $str, 'balanceSheetHistoryQuarterly', 'balanceSheetStatements');
    	_updateYahooFinancialsData(&$arQuarter, $str, 'cashflowStatementHistoryQuarterly', 'cashflowStatements');
//    	DebugArray($arQuarter);
    	return array($arAnnual, $arQuarter);
    }
    	
   	return false;
}

?>
