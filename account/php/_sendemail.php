<?php
require_once('../../php/account.php');

function _emailAll($strContents, $strSubject) 
{
	if ($result = SqlGetMemberEmails()) 
	{
		while ($member = mysql_fetch_assoc($result)) 
		{
			EmailHtml($member['email'], $strSubject, $strContents);
		}
		@mysql_free_result($result);
	}
}

	AcctAuth();
	if (!AcctIsAdmin())		SwitchToLink("../profile.php");
	
	if (isset($_POST['submit']))
	{
//		$strContents = UrlCleanString($_POST['contents']);
		$strSubmit = $_POST['submit'];
		unset($_POST['submit']);
		if ($strSubmit == "Send Email")
		{	// send email
//			_emailAll($strContents, 'Test');
			_emailAll($_POST['contents'], $_POST['subject']);
		}
		SwitchToLink("../profile.php");
	}
	
	$strContents = 'Email contents';
	$strSubject = 'Email subject'; 
	$strId = $_SESSION['SESS_ID'];
?>
