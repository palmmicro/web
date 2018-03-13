<?php
require_once('/php/email.php');
require_once('/php/account.php');
require_once('/php/stocklink.php');
require_once('_stock.php');

    AcctNoAuth();
    if (AcctIsAdmin())
	{
	    if ($strId = UrlGetQueryValue('delete'))
	    {
	        SqlDeleteTableDataById(TABLE_STOCK_CALIBRATION, $strId);
	    }
	}
	
	SwitchToSess();
?>
