<?php

/*
"S&P OIL & GAS  EXPLORATION & PR","exchangeTimezoneName":"America\u002FNew_York","regularMarketChange":{"raw":216.1001,"fmt":"216.10"},
"regularMarketPreviousClose":{"raw":5773.2,"fmt":"5,773.20"},
"fiftyTwoWeekHighChange":{"raw":-77.529785,"fmt":"-77.53"},
"exchangeTimezoneShortName":"EDT","fiftyTwoWeekLowChange":{"raw":176.91992,"fmt":"176.92"},
"exchangeDataDelayedBy":0,"regularMarketDayLow":{"raw":5773.2,"fmt":"5,773.20"},
"priceHint":2,"currency":"USD","regularMarketPrice":{"raw":5950.12,"fmt":"5,950.12"},
"regularMarketVolume":{"raw":0,"fmt":"0","longFmt":"0"}
*/

function preg_match_market_watch($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strLeft = ':{"raw":';
    $strMid = '[^,]*';
    $strRight = ',"fmt":"[\d,.-]*"},';
//    $strPattern .= RegExpParenthesis('"S&P\s*OIL\s*&\s*GAS\s*EXPLORATION\s*&\s*PR","exchangeTimezoneName":"America\\\\u002FNew_York","regularMarketChange"'.$strLeft, $strMid, $strRight);
//    $strPattern .= RegExpParenthesis('"regularMarketPreviousClose"'.$strLeft, $strMid, $strRight);
//    $strPattern .= RegExpParenthesis('"fiftyTwoWeekHighChange"'.$strLeft, $strMid, $strRight);
//    $strPattern .= RegExpParenthesis('"exchangeTimezoneShortName":"EDT","fiftyTwoWeekLowChange"'.$strLeft, $strMid, $strRight);
//    $strPattern .= RegExpParenthesis('"exchangeDataDelayedBy":\d*,"regularMarketDayLow"'.$strLeft, $strMid, $strRight);
    $strPattern .= RegExpParenthesis('"priceHint":\d*,"currency":"USD","regularMarketPrice"'.$strLeft, $strMid, $strRight);
    $strPattern .= $strBoundary;
//    DebugString($strPattern);
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function MarketWatchGetUrl($sym)
{
/*	if ($strSymbol = $sym->GetMarketWatchSymbol())
	{
		return "https://www.marketwatch.com/investing/index/$strSymbol/historical?countrycode=xx";
	}
	return false;*/
	return 'https://finance.yahoo.com/quote/%5ESPSIOP?ltr=1';
//	return 'https://xueqiu.com/u/woody1234';
}

function MarketWatchGetData($strSymbol)
{ 
	$sym = new StockSymbol($strSymbol);
    $strUrl = MarketWatchGetUrl($sym);
    DebugString('MarketWatch: '.$strUrl);
    $str = url_get_contents($strUrl);
//    DebugString($str);
    $arMatch = preg_match_market_watch($str);
    foreach ($arMatch as $ar)
    {
    	foreach ($ar as $str)
    	{
    		DebugString($str);
    	}
    }
//    return $str;
}

?>
