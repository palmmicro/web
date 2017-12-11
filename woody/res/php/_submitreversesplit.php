<?php
require_once('_stock.php');
require_once('_editreversesplitform.php');

    AcctAuth();

	if (isset($_POST['submit']))
	{
		if ($strSymbol = UrlGetQueryValue('edit'))
		{
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
