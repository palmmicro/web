<?php
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');

// ****************************** Common China fund functions *******************************************************
function EchoTitle($bChinese = true)
{
    global $group;
    
    $str = _GetStockDisplay($group->ref->stock_ref);
    if ($bChinese)
    {
        $str .= '净值';
    }
    else
    {
        $str .= ' Net Value';
    }
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
