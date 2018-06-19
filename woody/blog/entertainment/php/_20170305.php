<?php
require_once('_entertainment.php');
require_once('_stockdemo.php');

function EchoFundEst($bChinese = true)
{
    StockPrefetchData(FUND_DEMO_SYMBOL);
	EchoFundEstDemo($bChinese);
}

?>
