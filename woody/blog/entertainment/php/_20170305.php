<?php
require_once('_entertainment.php');
require_once('_stockdemo.php');

function EchoFundEst($bChinese = true)
{
    StockPrefetchData(array(FUND_DEMO_SYMBOL));
	EchoFundEstDemo($bChinese);
}

?>
