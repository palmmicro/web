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

define('YAHOO_QUOTES_FLAGS', 'l1t1p2nd1poghvn4');
// l1-Last Trade (Price Only), t1-Last Trade Time, p2-Change in Percent, n-Name, d1-Last Trade Date, p-Previous Close, o-Open, g-Day's Low, h-Day's High, v-Volume, n4-Notes
define('YAHOO_QUOTES_URL', 'https://finance.yahoo.com/d/quotes.csv?');
function GetYahooQuotes($strSymbols)
{ 
    $strUrl = YAHOO_QUOTES_URL."s=$strSymbols&f=".YAHOO_QUOTES_FLAGS;   // .'&e=.csv'; 
//    $strUrl = 'https://finance.yahoo.com/d/quotes.csv?s=XOP+%5ESPSIOP&f=l1t1p2nd1p';
    $str = url_get_contents($strUrl);
//    DebugString('Yahoo:'.$strSymbols);
//    DebugString($str);
    return $str;
}

function IsYahooStrError($str)
{
    $str = trim($str);
    if (strlen($str) == 0 || strstr($str, 'html') || strstr($str, '<head>'))
    {
        return true;
    }
    return false;
}

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
    if (RegExpDebug($arMatch, 'Yahoo stock', 16) == 0)	return false;
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
    $str = url_get_contents($strUrl);
	if ($arMatch = _preg_match_yahoo_stock($str))
	{
		foreach ($arMatch as $ar)
		{
			if ($ar[4] == $strSymbol)
			{
				$strMatchPrice = $ar[3];
				$ymd = new TickYMD($ar[1]);
				$strDate = $ymd->GetYMD();
    			$sql = new NavHistorySql($strStockId);
    			$sql->Write($strDate, $strMatchPrice);
				return $strMatchPrice.' '.$ar[2].' '.$strDate.' '.$ymd->GetHMS();
			}
		}
	}
    return false;
}

function YahooGetWebData($ref)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
    $sym = $ref->GetSym();
    $strSymbol = $sym->GetSymbol();
    $strStockId = $ref->GetStockId();
    if ($sym->IsIndex())
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
   		if ($strSymbol == 'USO' || $strSymbol == 'DBC')	return false;
   	}
   	return GetYahooNetValueSymbol($strSymbol);
}

function YahooUpdateNetValue($strSymbol)
{
	if (($strNetValueSymbol = _yahooGetNetValueSymbol($strSymbol)) == false)	return;
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  					return;
	$sql = new NavHistorySql($strStockId);
	
    date_default_timezone_set(STOCK_TIME_ZONE_US);
    $now_ymd = new NowYMD();
    $strDate = $now_ymd->GetYMD();
    if ($sql->Get($strDate))								return;
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
    	if ($sql->Get($strDate))		return;
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
    			$extra_sql = new NavHistorySql($strExtraId);
    			$extra_ymd = _yahooStockMatchGetYmd($arMatch, $strMatchSymbol);
    			$extra_sql->Insert($extra_ymd->GetYMD(), $strMatchPrice);
    		}
    	}
    }
}

?>
