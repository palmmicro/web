<?php
require_once('/php/account.php');

	AcctNoAuth();
	if (AcctIsAdmin())
	{
		AdminCommand();
	}
	
	SwitchToSess();
?>
