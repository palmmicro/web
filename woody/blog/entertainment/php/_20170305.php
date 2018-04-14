<?php
require_once('/php/stock.php');
require_once('/php/ui/fundestparagraph.php');

define('FUND_DEMO_SYMBOL', 'SZ162411');

function EchoFundEstDemo($bChinese)
{
    StockPrefetchData(array(FUND_DEMO_SYMBOL));
	$fund_ref = StockGetFundReference(FUND_DEMO_SYMBOL);
	EchoFundEstParagraph($fund_ref, $bChinese);
}

?>
