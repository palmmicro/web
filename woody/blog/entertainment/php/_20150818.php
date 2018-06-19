<?php
require_once('_entertainment.php');
require_once('_stockdemo.php');

function DemoPrefetchData()
{
    StockPrefetchArrayData(array(AH_DEMO_SYMBOL, ADRH_DEMO_SYMBOL, FUND_DEMO_SYMBOL));
}

?>
