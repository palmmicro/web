<?php
require_once('/php/email.php');
require_once('/php/account.php');
require_once('/php/stocklink.php');
require_once('_stock.php');

    AcctNoAuth();

	if ($strId = UrlGetQueryValue('delete'))
	{
	    if (AcctIsAdmin())
	    {
	        SqlDeleteTableDataById('stockcalibration', $strId);
	    }
	}
	
	SwitchToSess();
?>
