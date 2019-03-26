<?php
require_once('_entertainment.php');
require_once('_stockdemo.php');

function EchoFundEst()
{
    StockPrefetchData(FUND_DEMO_SYMBOL);
	EchoFundEstDemo(FUND_DEMO_SYMBOL);
}

?>
