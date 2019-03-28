<?php
require_once('_entertainment.php');
require_once('/php/stock.php');

function EchoSinaStockLink($strSymbol)
{
	echo GetSinaStockLink(new StockSymbol($strSymbol));
}

function EchoSinaFutureLink($strSymbol)
{
	echo GetSinaFutureLink($strSymbol);
}

?>
