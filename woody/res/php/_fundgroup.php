<?php
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');

// ****************************** Common China fund functions *******************************************************
function EchoTitle()
{
    global $group;
    
    $str = RefGetStockDisplay($group->ref->stock_ref).STOCK_DISP_NETVALUE;
    echo $str;
}

?>
