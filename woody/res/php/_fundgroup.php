<?php
require_once('/php/ui/fundestparagraph.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/tradingparagraph.php');
require_once('/php/ui/fundhistoryparagraph.php');

// ****************************** Common China fund functions *******************************************************
function GetTitle()
{
    global $acct;
	return $acct->GetStockDisplay().STOCK_DISP_NETVALUE;
}

class FundGroupAccount extends GroupAccount 
{
    function GetStockDisplay()
    {
    	$ref = $this->GetRef();
        return RefGetStockDisplay($ref->GetStockRef());
    }
}

?>
