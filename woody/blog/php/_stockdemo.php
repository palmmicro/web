<?php
require_once('/php/stock.php');
require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/lofsmaparagraph.php');
require_once('/php/ui/nvclosehistoryparagraph.php');
require_once('/php/ui/stockhistoryparagraph.php');

define('AB_DEMO_SYMBOL', 'SZ200488');
define('ADRH_DEMO_SYMBOL', '00700');
define('AH_DEMO_SYMBOL', '00386');
define('FUND_DEMO_SYMBOL', 'SZ162411');
define('STOCK_DEMO_SYMBOL', 'XOP');

function DemoPrefetchData()
{
    StockPrefetchData(AB_DEMO_SYMBOL, ADRH_DEMO_SYMBOL, AH_DEMO_SYMBOL, FUND_DEMO_SYMBOL, STOCK_DEMO_SYMBOL);
}

function EchoReferenceDemo($strSymbol = FUND_DEMO_SYMBOL)
{
    $ref = new MyStockReference($strSymbol);
    EchoReferenceParagraph(array($ref));
}

function EchoLofSmaDemo($strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoLofSmaParagraph($fund_ref);
}

function EchoStockHistoryDemo($strSymbol = STOCK_DEMO_SYMBOL)
{
    $ref = new MyStockReference($strSymbol);
   	EchoStockHistoryParagraph($ref);
}

function EchoFundHistoryDemo($strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoFundHistoryParagraph($fund_ref);
}

function EchoFundEstDemo($strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoFundArrayEstParagraph(array($fund_ref));
}

function EchoNvCloseDemo($strSymbol = STOCK_DEMO_SYMBOL)
{
    $ref = new MyStockReference($strSymbol);
   	EchoNvCloseHistoryParagraph($ref);
}

function EchoAbDemo($strSymbol = AB_DEMO_SYMBOL)
{
}

function EchoAhDemo($strSymbol = AH_DEMO_SYMBOL)
{
   	$hshare_ref = new HShareReference($strSymbol);
   	EchoAhParagraph(array($hshare_ref));
}

function EchoAdrhDemo($strSymbol = ADRH_DEMO_SYMBOL)
{
   	$hshare_ref = new HShareReference($strSymbol);
   	EchoAdrhParagraph(array($hshare_ref));
}

?>
