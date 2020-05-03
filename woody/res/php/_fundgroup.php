<?php
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');

// ****************************** Common China fund functions *******************************************************
function EchoTitle()
{
//    global $group;
    global $acct;
    
//    $str = RefGetStockDisplay($group->ref->stock_ref).STOCK_DISP_NETVALUE;
    $str = RefGetStockDisplay($acct->ref->stock_ref).STOCK_DISP_NETVALUE;
    echo $str;
}

class FundGroupAccount extends GroupAccount 
{
	var $ref;
	
    function FundGroupAccount()
    {
        parent::GroupAccount();
    }
    
    function GetRef()
    {
    	return $this->ref;
    }
}

?>
