<?php
require_once('../../php/account.php');

	AcctAuth();
	if (!AcctIsAdmin())		SwitchToLink("../profile.php");
	
	if (isset($_POST['submit']))
	{
//		$strContents = FormatCleanString($_POST['contents']);
		$strSubmit = $_POST['submit'];
		unset($_POST['submit']);
		if ($strSubmit == "Send Email")
		{	// send email
//			EmailAll($strContents, 'Test');
			EmailAll($_POST['contents'], $_POST['subject']);
		}
		SwitchToLink("../profile.php");
	}
	
	$strContents = 'Email contents';
	$strSubject = 'Email subject'; 
	$strId = $_SESSION['SESS_ID'];
?>
