<?php
require_once('/php/account.php');
require_once('_editprofileform.php');

function _emailProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature, $strStatus)
{
    $strSubject = 'Profile Changed';
	$str = GetMemberLink($strMemberId, true);
    $str .= '<br />Name: '.$strName; 
    $str .= '<br />Phone: '.$strPhone; 
    $str .= '<br />Address: '.$strAddress; 
    $str .= '<br />Web: '.$strWeb; 
    $str .= '<br />Signature: '.$strSignature; 
    $str .= '<br />Status: '.$strStatus; 
    EmailReport($str, $strSubject); 
}

function _onEdit($strMemberId)
{
	// Sanitize the POST values
	$strName = UrlCleanString($_POST['name']);
	$strPhone = UrlCleanString($_POST['phone']);
	$strAddress = UrlCleanString($_POST['address']);
	$strWeb = UrlCleanString($_POST['web']);
	$strSignature = UrlCleanString($_POST['signature']);

	if (!SqlUpdateProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature))
	{	
		return false;
	}

	$strStatus = UrlCleanString($_POST['status']);
	if (!SqlUpdateStatus($strMemberId, $strStatus))
	{    
		return false;
	}
	
	_emailProfile($strMemberId, $strName, $strPhone, $strAddress, $strWeb, $strSignature, $strStatus);
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
		
		if ($strSubmit == ACCOUNT_PROFILE_EDIT)
		{
		    SwitchToLink("../profile.php");
		}
		else if ($strSubmit == ACCOUNT_PROFILE_EDIT_CN)
		{
		    SwitchToLink("../profilecn.php");
		}
	}

	SwitchToSess();
?>
