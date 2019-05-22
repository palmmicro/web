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

function EchoShortName()
{
    global $group;
    
    $ar = explode('-', RefGetDescription($group->ref->stock_ref));
    $str = $ar[0];
    echo $str;
}

?>
