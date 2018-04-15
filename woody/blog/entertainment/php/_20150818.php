<?php
require_once('/php/stock.php');
require_once('/php/stockhis.php');
//require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/ahparagraph.php');
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');
require_once('/php/ui/lofsmaparagraph.php');

define('AH_DEMO_SYMBOL', '00386');
define('ADRH_DEMO_SYMBOL', '00700');
define('FUND_DEMO_SYMBOL', 'SZ162411');

function DemoPrefetchData()
{
    StockPrefetchData(array(AH_DEMO_SYMBOL, ADRH_DEMO_SYMBOL, FUND_DEMO_SYMBOL));
}

function EchoReferenceDemo($bChinese)
{
    $ref = new MyStockReference(FUND_DEMO_SYMBOL);
    EchoReferenceParagraph(array($ref), $bChinese);
}

function EchoLofSmaDemo($bChinese)
{
	$fund_ref = StockGetFundReference(FUND_DEMO_SYMBOL);
	EchoLofSmaParagraph($fund_ref, false, $bChinese);
}

function EchoFundHistoryDemo($bChinese)
{
	$fund_ref = StockGetFundReference(FUND_DEMO_SYMBOL);
	EchoFundHistoryParagraph($fund_ref, $bChinese);
}

function EchoFundEstDemo($bChinese)
{
	$fund_ref = StockGetFundReference(FUND_DEMO_SYMBOL);
	EchoFundArrayEstParagraph(array($fund_ref), '', $bChinese);
}

function EchoAhDemo($bChinese)
{
    $a_ref = new MyStockReference(SqlGetHaPair(AH_DEMO_SYMBOL));
   	$hshare_ref = new HShareReference(AH_DEMO_SYMBOL, $a_ref);
   	EchoAhParagraph(array($hshare_ref), $bChinese);
}

function EchoAdrhDemo($bChinese)
{
    $adr_ref = new MyStockReference(SqlGetHadrPair(ADRH_DEMO_SYMBOL));
   	$hadr_ref = new HAdrReference(ADRH_DEMO_SYMBOL, false, $adr_ref);
   	EchoAdrhParagraph(array($hadr_ref), $bChinese);
}

?>
