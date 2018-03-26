<?php
require_once('/php/account.php');

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
