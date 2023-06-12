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
    	if (method_exists($ref, 'GetStockRef'))
    	{
    		$stock_ref = $ref->GetStockRef();
    		$nav_ref = $ref;
    	}
    	else
    	{
    		$stock_ref = $ref;
    		$nav_ref = $ref->GetNavRef();
    	}

    	$str = $nav_ref->GetChineseName();
    	$str = str_replace('(人民币份额)', '', $str);
    	$str = str_replace('(人民币)', '', $str);
    	return RefGetStockDisplay($stock_ref).$str;
    }
}

?>
