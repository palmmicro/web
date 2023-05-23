<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('../../php/ui/fundestparagraph.php');
require_once('../../php/ui/referenceparagraph.php');
require_once('../../php/ui/tradingparagraph.php');
require_once('../../php/ui/smaparagraph.php');
require_once('../../php/ui/fundhistoryparagraph.php');
require_once('../../php/ui/fundshareparagraph.php');

function GetTitle()
{
    global $acct;
	return $acct->GetStockDisplay().STOCK_DISP_NAV;
}

class FundGroupAccount extends GroupAccount 
{
    function GetStockDisplay()
    {
    	$ref = $this->GetRef();
    	if (method_exists($ref, 'GetStockRef'))		return RefGetStockDisplay($ref->GetStockRef()).$ref->GetChineseName();
    	
    	$nav_ref = $ref->GetNavRef();
    	return RefGetStockDisplay($ref).$nav_ref->GetChineseName();
    }
}

?>
