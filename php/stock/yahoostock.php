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
function YahooGetStockHistory($strSymbol, $iTimeBegin, $iTimeEnd)
{
    $strUrl = 'https://finance.yahoo.com/quote/'.$strSymbol.'/history?period1='.strval($iTimeBegin).'&period2='.strval($iTimeEnd).'&interval=1d&filter=history&frequency=1d';
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

?>
