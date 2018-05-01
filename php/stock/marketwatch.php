<?php

function MarketWatchGetUrl($sym)
{
/*	if ($strSymbol = $sym->GetMarketWatchSymbol())
	{
		return "https://www.marketwatch.com/investing/index/$strSymbol/historical?countrycode=xx";
	}
	return false;*/
	return 'https://markets.ft.com/data/indices/tearsheet/summary?s=SPGOGUP:REU';
}

function MarketWatchGetData($strSymbol)
{ 
	$sym = new StockSymbol($strSymbol);
    $strUrl = MarketWatchGetUrl($sym);
    DebugString('MarketWatch: '.$strUrl);
    $str = url_get_contents($strUrl);
    DebugString($str);
    return $str;
}

?>
