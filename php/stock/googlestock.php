<?php

/*
http://www.google.com/finance/info?q=NASDAQ:GOOG
http://www.google.com/finance/info?q=CURRENCY:GBPUSD,INDEXSP:SPSIOP,AAPL,YHOO
http://finance.google.com/finance/info?client=ig&q=AAPL,YHOO
charts -- https://www.google.com/finance/getchart?q=YELP
https://finance.google.com/finance?q=BVMF:TPIS3&output=json
*/
define ('GOOGLE_QUOTES_URL', 'https://finance.google.com/finance?q=');
function GetGoogleQuotes($strSymbols)
{ 
    $strUrl = GOOGLE_QUOTES_URL.$strSymbols.'&output=json';
    $str = url_get_contents($strUrl);
//    DebugString('Google:'.$strSymbols);
//    DebugString('Google:'.$strUrl);
    if (strchr($str, 'Response Code 400'))      return false;   // Google returns error in text 'httpserver.cc: Response Code 400'
    $str = ltrim($str, "\n// [ ");
    $str = rtrim($str, "\n]");
//    DebugString($str);
    return $str;
}

/* history
http://www.google.com/finance/historical?q=NASDAQ:AAPL&startdate=Jan+01%2C+2000&output=csv
http://www.google.com/finance/historical?q=NASDAQ:ADBE&startdate=Jan+01%2C+2009&enddate=Aug+2%2C+2012&output=csv
https://finance.google.com/finance/historical?q=NYSE:WMT+&+startdate=Nov+3+2015+&+enddate=Nov+2+2017+&+output=csv
*/
define ('GOOGLE_HISTORY_QUOTES_URL', 'http://www.google.com/finance/historical?q=');
function StockGetGoogleHistoryQuotes($strSymbol, $strStartDate, $strEndDate)
{ 
    $strUrl = GOOGLE_HISTORY_QUOTES_URL."$strSymbol&startdate=$strStartDate&enddate=$strEndDate&output=csv"; 
    DebugString('Google history:'.$strUrl);
    return url_get_contents($strUrl);
}


?>
