<?php
require_once('/php/account.php');
require_once('/php/ui/editinputform.php');

    AcctSessionStart();
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strInput = UrlCleanString($_POST[EDIT_INPUT_NAME]);
		if (!empty($strInput))
		{
			$strLink = UrlGetUri(SwitchGetSess()).'?'.EDIT_INPUT_NAME.'='.$strInput;
//			DebugString('_submitinput.php '.$strLink);
			SwitchToLink($strLink);
		}
	}
	SwitchToSess();
	
?>
