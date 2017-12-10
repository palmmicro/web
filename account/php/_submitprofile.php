<?php
require_once('/php/account.php');
require_once('_editprofileform.php');

function _onEdit($strMemberId)
{
	// Sanitize the POST values
	$strName = FormatCleanString($_POST['name']);
	$strPhone = FormatCleanString($_POST['phone']);
	$strAddress = FormatCleanString($_POST['address']);
	$strWeb = FormatCleanString($_POST['web']);
	$strSignature = FormatCleanString($_POST['signature']);

	if (!SqlUpdateProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature))
	{	
		return false;
	}

	$strStatus = FormatCleanString($_POST['status']);
	if (!SqlUpdateStatus($strMemberId, $strStatus))
	{    
		return false;
	}
	
	EmailProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature, $strStatus);
	return true;
}

    $strMemberId = AcctAuth();
	if (isset($_POST['submit']))
	{
		$strSubmit = $_POST['submit'];
		if ($strSubmit == ACCOUNT_PROFILE_EDIT || $strSubmit == ACCOUNT_PROFILE_EDIT_CN)
		{	// edit profile
		    _onEdit($strMemberId);
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
