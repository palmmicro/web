<?php
require_once('_account.php');
require_once('_editprofileform.php');

function _getEditProfileSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = ACCOUNT_PROFILE_EDIT_CN;
    }
    else
    {
        $str = ACCOUNT_PROFILE_EDIT;
    }
    return $str;
}

function EchoAll($bChinese = true)
{
    global $acct;
    
    $strSubmit = _getEditProfileSubmit($bChinese);
    EditProfileForm($strSubmit, $acct->GetLoginId());
}

function GetMetaDescription($bChinese = true)
{
	$str = _getEditProfileSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_submitprofile.php和/account/php/_editprofileform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_submitprofile.php and php/_editprofileform.php to $str.";
    }
    return CheckMetaDescription($str);
}

function GetTitle($bChinese = true)
{
	return _getEditProfileSubmit($bChinese);
}

   	$acct = new Account();
	$acct->Auth();
?>
