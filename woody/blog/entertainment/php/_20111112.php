<?php
require_once('_entertainment.php');
require_once('_stockdemo.php');

function EchoStockPrice($bChinese = true)
{
	$strSymbol = STOCK_DEMO_SYMBOL;
	$sym = new StockSymbol($strSymbol);
	$strLink = GetSinaQuotesLink($sym->GetSinaSymbol());
	
	EchoReferenceDemo($bChinese, $strSymbol);
	EchoParagraph($strLink);
}

?>
