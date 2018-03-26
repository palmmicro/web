<?php
require_once('/php/account.php');

    AcctSessionStart();
	$strIp = false;
	$bChinese = true;
    if (isset($_POST['submit']))
	{
		$strIp = UrlCleanString($_POST['ip']);
		if ($_POST['submit'] == 'Submit')    $bChinese = false;
		unset($_POST['submit']);
	}
	$strLink = '/account/ip'.UrlGetPhp($bChinese).'?ip='.$strIp;
	SwitchToLink($strLink);
	
?>
    