<?php

/*
Yahoo Finance API tags:
Pricing                              Dividends 
a: Ask                               y: Dividend Yield 
b: Bid                               d: Dividend per Share 
b2: Ask (Realtime)                   r1: Dividend Pay Date 
b3: Bid (Realtime)                   q: Ex-Dividend Date 
p: Previous Close  
o: Open  
                                     Date 
c1: Change                           d1: Last Trade Date 
c: Change & Percent Change           d2: Trade Date 
c6: Change (Realtime)                t1: Last Trade Time 
k2: Change Percent (Realtime)  
p2: Change in Percent  
                                     Averages 
c8: After Hours Change (Realtime)    m5: Change From 200 Day Moving Average 
c3: Commission                       m6: Percent Change From 200 Day Moving Average 
g: Day's Low                         m7: Change From 50 Day Moving Average 
h: Day's High                        m8: Percent Change From 50 Day Moving Average 
k1: Last Trade (Realtime) With Time  m3: 50 Day Moving Average 
l: Last Trade (With Time)            m4: 200 Day Moving Average 
l1: Last Trade (Price Only)  
t8: 1 yr Target Price  
                                     Misc 
w1: Day’s Value Change              g1: Holdings Gain Percent 
w4: Day’s Value Change (Realtime)   g3: Annualized Gain 
p1: Price Paid                       g4: Holdings Gain 
m: Day’s Range                      g5: Holdings Gain Percent (Realtime) 
m2: Day’s Range (Realtime)          g6: Holdings Gain (Realtime) 
52 Week Pricing Symbol Info 
k: 52 Week High                      v: More Info 
j: 52 week Low                       j1: Market Capitalization 
j5: Change From 52 Week Low          j3: Market Cap (Realtime) 
k4: Change From 52 week High         f6: Float Shares 
j6: Percent Change From 52 week Low  n: Name 
k5: Percent Change From 52 week High n4: Notes 
w: 52 week Range                     s: Symbol 
s1: Shares Owned 
x: Stock Exchange 
j2: Shares Outstanding 
Volume 
v: Volume  
a5: Ask Size  
b6: Bid Size Misc 
k3: Last Trade Size                  t7: Ticker Trend 
a2: Average Daily Volume             t6: Trade Links 
i5: Order Book (Realtime) 
Ratios
l2: High Limit 
e: Earnings per Share                l3: Low Limit 
e7: EPS Estimate Current Year        v1: Holdings Value 
e8: EPS Estimate Next Year           v7: Holdings Value (Realtime) 
e9: EPS Estimate Next Quarter        s6 Revenue 
b4: Book Value  
j4: EBITDA  
p5: Price / Sales  
p6: Price / Book  
r: P/E Ratio  
r2: P/E Ratio (Realtime)  
r5: PEG Ratio  
r6: Price / EPS Estimate Current Year  
r7: Price / EPS Estimate Next Year  
s7: Short Ratio 
*/

define ('YAHOO_QUOTES_FLAGS', 'l1t1p2nd1poghvn4');
// l1-Last Trade (Price Only), t1-Last Trade Time, p2-Change in Percent, n-Name, d1-Last Trade Date, p-Previous Close, o-Open, g-Day's Low, h-Day's High, v-Volume, n4-Notes
define ('YAHOO_QUOTES_URL', 'https://finance.yahoo.com/d/quotes.csv?');
function GetYahooQuotes($strSymbols)
{ 
    // http://finance.yahoo.com/d/quotes.csv?s= STOCK SYMBOLS &f= FORMAT TAGS
    $strUrl = YAHOO_QUOTES_URL."s=$strSymbols&f=".YAHOO_QUOTES_FLAGS;   // .'&e=.csv'; 
//    $strUrl = 'https://finance.yahoo.com/d/quotes.csv?s=XOP+%5ESPSIOP&f=l1t1p2nd1p';
    $str = url_get_contents($strUrl);
//    DebugString('Yahoo:'.$strSymbols);
//    DebugString($str);
    return $str;
}
/*
// http://table.finance.yahoo.com/table.csv?s=XOP&d=7&e=19&f=2015&g=d&a=6&b=19&c=2015&ignore=.csv
define ('YAHOO_HISTORY_QUOTES_URL', 'https://chart.finance.yahoo.com/table.csv?');
function GetYahooHistoryQuotes($strSymbol, $strBeginY, $strBeginM, $strBeginD, $strEndY, $strEndM, $strEndD)
{ 
    $strUrl = YAHOO_HISTORY_QUOTES_URL."s=$strSymbol&d=$strEndM&e=$strEndD&f=$strEndY&g=d&a=$strBeginM&b=$strBeginD&c=$strBeginY&ignore=.csv"; 
//    DebugString('Yahoo:'.$strUrl);
    return url_get_contents($strUrl);
}
*/
function IsYahooStrError($str)
{
    $str = trim($str);
    if (strlen($str) == 0 || strchr($str, 'html') || strchr($str, '<head>'))
    {
        return true;
    }
    return false;
}
/*
function GetYahooPastQuotes($strSymbol, $iDays)
{ 
    $iTime = time();
    $localtime = localtime($iTime);
    $strEndY = strval($localtime[5] + 1900);
    $strEndM = strval($localtime[4]);
    $strEndD = strval($localtime[3]);

    $iTime -= $iDays * SECONDS_IN_DAY;
    $localtime = localtime($iTime);
    $strBeginY = strval($localtime[5] + 1900);
    $strBeginM = strval($localtime[4]);
    $strBeginD = strval($localtime[3]);

    return GetYahooHistoryQuotes($strSymbol, $strBeginY, $strBeginM, $strBeginD, $strEndY, $strEndM, $strEndD);
}
*/

// https://finance.yahoo.com/quote/XOP/history?period1=1467122442&period2=1498658442&interval=1d&filter=history&frequency=1d 
// https://query1.finance.yahoo.com/v7/finance/download/XOP?period1=1467122442&period2=1498658442&interval=1d&events=history&crumb=EMGTmG8UgZ4
define ('YAHOO_HISTORY_QUOTES_URL', 'https://finance.yahoo.com/quote/');
function YahooGetStockHistory($strSymbol, $iTimeBegin, $iTimeEnd)
{
    $strUrl = YAHOO_HISTORY_QUOTES_URL.$strSymbol.'/history?period1='.strval($iTimeBegin).'&period2='.strval($iTimeEnd).'&interval=1d&filter=history&frequency=1d';
//    DebugString($strUrl);
    $str = url_get_contents($strUrl); 
    return $str;
}

/*
<tr class="BdT Bdc($c-fuji-grey-c) Ta(end) Fz(s) Whs(nw)" data-reactid="51">
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
        $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Pstart\(10px\)" data-reactid="\d*"><span data-reactid="\d*">', '[^<]*', '</span></td>');
    }
    $strPattern .= $strBoundary;
//    DebugString($strPattern);
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function _debugPregMatch($arMatch, $strSrc, $iMin)
{
	$iCount = count($arMatch);
    if ($iCount > $iMin)
    {
    	DebugString($strSrc.' '.strval($iCount).':');
    	foreach ($arMatch as $ar)
    	{
    		foreach ($ar as $str)	DebugString($str);
    	}
    }
    return $iCount;
}

/*
"^VIX":{
"sourceInterval":15,
"exchange":"WCB",
"regularMarketTime":{"raw":1524255297,"fmt":"4:14PM EDT"},
"shortName":"Vix",
"exchangeTimezoneName":"America\u002FNew_York",
"regularMarketChange":{"raw":0.9199991,"fmt":"0.92"},
"regularMarketPreviousClose":{"raw":15.96,"fmt":"15.96"},
"exchangeTimezoneShortName":"EDT",
"exchangeDataDelayedBy":20,
"regularMarketPrice":{"raw":16.88,"fmt":"16.88"},
"gmtOffSetMilliseconds":-14400000,
"marketState":"CLOSED",
"quoteType":"INDEX",
"symbol":"^VIX",
"language":"en-US",
"market":"us_market",
"regularMarketChangePercent":{"raw":5.7644053,"fmt":"5.76%"},
"fullExchangeName":"Chicago Options",
"tradeable":false
},

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
*/

function _preg_match_yahoo_stock_data($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
//    $strPattern .= RegExpParenthesis('"regularMarketTime":{"raw":', RegExpDigit(), ',"fmt":"[^"]*"},');
//    $strPattern .= RegExpNoneSpace();
//  	$strPattern .= RegExpParenthesis('"fiftyTwoWeekRange":{', '[^}]*', '},');
//    	$strPattern .= RegExpNoneSpace();
//    $strPattern .= RegExpParenthesis('"shortName":"', '[^"]*', '",');
//    $strPattern .= RegExpNoneSpace();
//    $strPattern .= RegExpParenthesis('"exchangeDataDelayedBy":', RegExpDigit(), ',');
    $strPattern .= RegExpParenthesis('"regularMarketPrice":{"raw":', RegExpNumber(), ',"fmt":"[\d,.-]*"},');
  	$strPattern .= RegExpNoneSpace();
   	$strPattern .= RegExpParenthesis('"symbol":"', '[^"]*', '",');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    if (_debugPregMatch($arMatch, 'Yahoo stock data', 17) == 0)	return false;
    return $arMatch;
}

function _preg_match_yahoo_stock_time($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('"regularMarketTime":{"raw":', RegExpDigit(), ',"fmt":"[^"]*"},');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function _yahooStockMatchGetDate($str)
{
	$arMatch = _preg_match_yahoo_stock_time($str);
	$iCount = count($arMatch);
//   	DebugString('_preg_match_yahoo_stock_time - '.strval($iCount).':');
   	$arDate = array();
    foreach ($arMatch as $ar)
    {
//    	foreach ($ar as $str)	DebugString($str);
    	$ymd = new YMDTick($ar[1]);
    	$strDate = $ymd->GetYMD();
//    	DebugString($strDate);
       	if (array_key_exists($strDate, $arDate))	$arDate[$strDate] ++;
       	else											$arDate[$strDate] = 1;
    }
    
    $iMax = 0;
    $strMax = false;
    foreach ($arDate as $strDate => $iNum)
    {
    	if ($iNum > $iMax)
    	{
    		$iMax = $iNum;
    		$strMax = $strDate;
//    		DebugString($strMax.' '.strval($iMax));
    	}
    }
    
//	$ymd = new YMDString($strMax);
//	DebugString(sprintf('%s %02d:%02d', $ymd->GetYMD(), $ymd->GetHour(), $ymd->GetMinute()));
	return $strMax;
}

function YahooStockGetUrl($strYahooSymbol)
{
	return 'https://finance.yahoo.com/quote/'.$strYahooSymbol;
}

function _yahooStockGetData($strSymbol)
{ 
	$sym = new StockSymbol($strSymbol);
    $strUrl = YahooStockGetUrl($sym->GetYahooSymbol());
    $str = url_get_contents($strUrl);
	//    DebugString($str);
    $strDate = _yahooStockMatchGetDate($str);
	if ($arMatch = _preg_match_yahoo_stock_data($str))
	{
		foreach ($arMatch as $ar)
		{
			if ($ar[2] == $strSymbol)	return $strDate.' '.$ar[1];
		}
	}
    return false;
}

function TestYahooWebData($strSymbol)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsIndex())
    {
   		$str = _yahooStockGetData($strSymbol);
   	}
   	else
   	{
   		$str = _yahooStockGetData(GetYahooNetValueSymbol($strSymbol));
   	}
   	if ($str == false)	return '(Not found)';
   	return $str;
}

function _getNetValueDelayTick()
{	// get net value after 16:30
	return 16 * SECONDS_IN_HOUR + 30 * SECONDS_IN_MIN;
}

function _yahooNetValueHasFile($ymd_now, $strFileName)
{
	clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        if ($ymd_now->IsNewFile($strFileName))							return $str;   		// update on every minute
        
       	$strDate = _yahooStockMatchGetDate($str);
       	$ymd = new YMDString($strDate);
       	if (($ymd->GetNextTradingDayTick() + _getNetValueDelayTick()) <= $ymd_now->GetTick())		return false;		// need update

//        DebugString($strFileName.' - Use current file');
        return $str;
    }
    return false;
}

function _insertFundHistory($strStockId, $strDate, $strVal)
{
	if (SqlGetFundHistoryByDate($strStockId, $strDate) == false)
    {
    	DebugString('Insert fund history: '.SqlGetStockSymbol($strStockId).' '.$strDate.':'.$strVal);
    	SqlInsertFundHistory($strStockId, $strDate, $strVal, '0', '0');
    }
}

function _yahooGetNetValueSymbol($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSymbolA() || $sym->IsSymbolH())
    {
    	return false;
    }
    else if ($sym->IsIndex())
    {
   		return $strSymbol;
   	}
   	else
   	{
   		if ($strSymbol == 'USO' || $strSymbol == 'DBC')	return false;
   	}
   	return GetYahooNetValueSymbol($strSymbol);
}

function _yahooNetValueReady($strStockId, $strDate)
{
    SqlCreateFundHistoryTable();
    if (SqlGetFundHistoryByDate($strStockId, $strDate))
    {
//    	DebugString(SqlGetStockSymbol($strStockId).' '.$strDate.': fund table entry existed');
    	return true;
    }
    return false;
}

function YahooUpdateNetValue($strSymbol)
{
	if (($strNetValueSymbol = _yahooGetNetValueSymbol($strSymbol)) == false)	return;
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  					return;
    date_default_timezone_set(STOCK_TIME_ZONE_US);
    $ymd_now = new YMDNow();
    $strDate = $ymd_now->GetYMD();
    if (_yahooNetValueReady($strStockId, $strDate))								return;
    if ($ymd_now->IsTradingDay())
    {
    	if ($ymd_now->GetTick() < (strtotime($strDate) + _getNetValueDelayTick()))
    	{
//    		DebugString($strSymbol.': Market not closed');
    		return;
    	}
    }
    
	$strFileName = DebugGetYahooWebFileName($strSymbol);
	$str = _yahooNetValueHasFile($ymd_now, $strFileName);
    if ($str == false)
    {
    	$sym = new StockSymbol($strNetValueSymbol);
    	$strUrl = YahooStockGetUrl($sym->GetYahooSymbol());
    	if ($str = url_get_contents($strUrl))
    	{
    		DebugString($strFileName.': Save new file');
    		file_put_contents($strFileName, $str);
    	}
    	else
    	{
    		DebugString($strUrl.': No data!');
    		return;
    	}
    }
	
   	$strDate = _yahooStockMatchGetDate($str);
    if (_yahooNetValueReady($strStockId, $strDate))		return;
    if ($arMatch = _preg_match_yahoo_stock_data($str))
    {
    	foreach ($arMatch as $ar)
    	{
    		if ($strNetValueSymbol == $ar[2])					_insertFundHistory($strStockId, $strDate, $ar[1]);
    		else if ($strExtraId = SqlGetStockId($ar[2]))		_insertFundHistory($strExtraId, $strDate, $ar[1]);
    	}
    }
}

?>
