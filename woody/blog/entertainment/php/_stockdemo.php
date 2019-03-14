<?php
require_once('/php/stock.php');
require_once('/php/stockhis.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/lofsmaparagraph.php');

define('FUND_DEMO_SYMBOL', 'SZ162411');
define('AH_DEMO_SYMBOL', '00386');
define('ADRH_DEMO_SYMBOL', '00700');
define('STOCK_DEMO_SYMBOL', 'IQ');

function EchoReferenceDemo($bChinese = true, $strSymbol = FUND_DEMO_SYMBOL)
{
    $ref = new MyStockReference($strSymbol);
    EchoReferenceParagraph(array($ref));
}

function EchoLofSmaDemo($bChinese = true, $strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoLofSmaParagraph($fund_ref, $bChinese);
}

function EchoFundHistoryDemo($bChinese = true, $strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoFundHistoryParagraph($fund_ref, $bChinese);
}

function EchoFundEstDemo($bChinese = true, $strSymbol = FUND_DEMO_SYMBOL)
{
	$fund_ref = StockGetFundReference($strSymbol);
	EchoFundArrayEstParagraph(array($fund_ref), $bChinese);
}

function EchoAhDemo($bChinese = true, $strSymbol = AH_DEMO_SYMBOL)
{
   	$hshare_ref = new HShareReference($strSymbol);
   	EchoAhParagraph(array($hshare_ref), $bChinese);
}

function EchoAdrhDemo($bChinese = true, $strSymbol = ADRH_DEMO_SYMBOL)
{
   	$hshare_ref = new HShareReference($strSymbol);
   	EchoAdrhParagraph(array($hshare_ref), $bChinese);
}

?>
