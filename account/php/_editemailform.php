<?php
require_once('/php/ui/htmlelement.php');

define('EDIT_EMAIL_REGISTER_CN', '注册新帐号');
define('EDIT_EMAIL_REGISTER', 'Register New Account');

define('EDIT_EMAIL_LOGIN_CN', '登录帐号');
define('EDIT_EMAIL_LOGIN', 'Login Account');

define('EDIT_EMAIL_PASSWORD_CN', '修改密码');
define('EDIT_EMAIL_PASSWORD', 'Change Password');

define('EDIT_EMAIL_UPDATE_CN', '修改登录帐号');
define('EDIT_EMAIL_UPDATE', 'Change Login Account');

define('EDIT_EMAIL_REMINDER_CN', '生成新密码');
define('EDIT_EMAIL_REMINDER', 'Reset Password');

define('EDIT_EMAIL_CLOSE_CN', '关闭帐号');
define('EDIT_EMAIL_CLOSE', 'Close Account');

define('ACCT_ERR_EMAIL_INPUT',			1);		// '登录电子邮件不能为空并且要求是有效的邮件地址' : 'Login email missing or not valid';
define('ACCT_ERR_EMAIL_REGISTERED',	2);		// '登录电子邮件已经注册' : 'Login Email already in use';
define('ACCT_ERR_EMAIL_UNREGISTERED',	3);		// '此电子邮件尚未注册' : 'Email not registered yet';
define('ACCT_ERR_EMAIL_UNCHANGED',		4);		// '新旧电子邮件没有区别' : 'New email is the same with the old one';
define('ACCT_ERR_PASSWORD_INPUT',		5);		// '密码不能为空' : 'Password missing';
define('ACCT_ERR_PASSWORD2_INPUT',		6);		// '重复密码不能为空' : 'Confirm password missing';
define('ACCT_ERR_PASSWORD_MISMATCH',	7);		// '密码不一致' : 'Passwords do not match';
define('ACCT_ERR_PASSWORD_UNCHANGED',	8);		// '新旧密码没有区别' : 'New password is the same with the old one';
define('ACCT_ERR_LOGIN_FAILED',		9);		// '请检查登录电子邮件帐号和密码' : 'Please check your login email and password';
define('ACCT_ERR_UNAUTH_OP',			10);	// '你没有权限做这个操作' : 'You are not authorized for this operation';

function _disableEditPassword($strSubmit)
{
    if ($strSubmit == EDIT_EMAIL_UPDATE_CN || $strSubmit == EDIT_EMAIL_UPDATE 
     || $strSubmit == EDIT_EMAIL_REMINDER_CN || $strSubmit == EDIT_EMAIL_REMINDER 
     || $strSubmit == EDIT_EMAIL_CLOSE_CN || $strSubmit == EDIT_EMAIL_CLOSE)
    {
        return true;
    }
    return false;
}

function _readonlyEditEmail($strSubmit, $bAdmin)
{
	switch ($strSubmit)
	{
	case EDIT_EMAIL_PASSWORD:
	case EDIT_EMAIL_PASSWORD_CN:
        return true;

	case EDIT_EMAIL_CLOSE:
	case EDIT_EMAIL_CLOSE_CN:
        if ($bAdmin == false)     return true;    // only admin can close other account
        break;
    }
    return false;
}

function EditEmailErrOcurred($arErrMsg)
{
	if (count($arErrMsg) > 0)
	{
		$_SESSION['MSG_ARRAY'] = $arErrMsg;
		return true;
	}
	return false;
}

function _editEmailCheckErrMsg()
{
	return (isset($_SESSION['MSG_ARRAY']) && is_array($_SESSION['MSG_ARRAY']) && count($_SESSION['MSG_ARRAY']) > 0);
}

function EditEmailForm($strSubmit, $strEmail, $bAdmin)
{
    $strEmailReadonly = '';
    $strPasswordDisabled = '';
    $strPassword2Disabled = '';
    if ($strSubmit == EDIT_EMAIL_REGISTER || $strSubmit == EDIT_EMAIL_LOGIN || $strSubmit == EDIT_EMAIL_PASSWORD 
      || $strSubmit == EDIT_EMAIL_UPDATE || $strSubmit == EDIT_EMAIL_REMINDER || $strSubmit == EDIT_EMAIL_CLOSE)
    {
        $bChinese = false;
        $strAction = 'profile.php';
        $strEmailDisplay = 'Your Email';
        $strPasswordDisplay = 'Password';
        $strPassword2Display = 'Confirm Password';
    }
    else
    {
        $bChinese = true;
        $strAction = 'profilecn.php';
        $strEmailDisplay = '你的电子邮件';
        $strPasswordDisplay = '密码';
        $strPassword2Display = '重复密码';
    }
    
    if (_disableEditPassword($strSubmit))
    {
        $strPasswordDisplay = '';
        $strPasswordDisabled = HtmlElementDisabled();
    }
    
    if (_disableEditPassword($strSubmit) || $strSubmit == EDIT_EMAIL_LOGIN_CN || $strSubmit == EDIT_EMAIL_LOGIN)
    {
        $strPassword2Display = '';
        $strPassword2Disabled = HtmlElementDisabled();
    }

    if (_readonlyEditEmail($strSubmit, $bAdmin))
    {
        $strEmailReadonly = HtmlElementReadonly();
    }

//    $strEmail = AcctGetEmail(); 
	$strEmailErr = '';
	$strPasswordErr = '';
	$strPassword2Err = '';
	$strSubmitErr = '';
	if (_editEmailCheckErrMsg()) 
	{
		$strEmail = $_SESSION['SESS_EMAIL_INPUT'];
		foreach($_SESSION['MSG_ARRAY'] as $iMsg) 
		{
			switch ($iMsg)
			{
			case ACCT_ERR_EMAIL_INPUT:
				$strEmailErr = $bChinese ? '登录电子邮件不能为空并且要求是有效的邮件地址' : 'Login email missing or not valid';
				break;

			case ACCT_ERR_EMAIL_UNREGISTERED:
				$strEmailErr = $bChinese ? '此电子邮件尚未注册' : 'Email not registered yet';
				break;
				
			case ACCT_ERR_EMAIL_REGISTERED:
				$strEmailErr = $bChinese ? '登录电子邮件已经注册' : 'Login email already in use';
				break;

			case ACCT_ERR_LOGIN_FAILED:
				$strEmailErr = $bChinese ? '请检查登录电子邮件帐号和密码' : 'Please check your login email and password';
				break;

			case ACCT_ERR_EMAIL_UNCHANGED:
				$strSubmitErr = $bChinese ? '新旧电子邮件没有区别' : 'New email is the same with the old one';
				break;
				
			case ACCT_ERR_PASSWORD_MISMATCH:
				$strSubmitErr = $bChinese ? '密码不一致' : 'Passwords do not match';
				break;

			case ACCT_ERR_UNAUTH_OP:
				$strSubmitErr = $bChinese ? '你没有权限做这个操作' : 'You are not authorized for this operation';
				break;
				
			case ACCT_ERR_PASSWORD_INPUT:
				$strPasswordErr = $bChinese ? '密码不能为空' : 'Password missing';
				break;

			case ACCT_ERR_PASSWORD_UNCHANGED:
				$strPasswordErr = $bChinese ? '新旧密码没有区别' : 'New password is the same with the old one';
				break;

			case ACCT_ERR_PASSWORD2_INPUT:
				$strPassword2Err = $bChinese ? '重复密码不能为空' : 'Confirm password missing';
				break;
			}
		}
		unset($_SESSION['MSG_ARRAY']);
	}
    
	echo <<< END
<form id="emailForm" name="emailForm" method="post" action="$strAction">
  <table width="640" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr>
      <td><b>$strEmailDisplay</b></td>
      <td><input name="login" value="$strEmail" type="text" size="40" maxlength="128" class="textfield" id="login" $strEmailReadonly></td>
      <td><font color=red>$strEmailErr</font></td>
    </tr>
    <tr>
      <td><b>$strPasswordDisplay</b></td>
      <td><input name="password" type="password" maxlength="32" class="textfield" id="password" $strPasswordDisabled></td>
      <td><font color=red>$strPasswordErr</font></td>
    </tr>
    <tr>
      <td><b>$strPassword2Display</b></td>
      <td><input name="cpassword" type="password" maxlength="32" class="textfield" id="cpassword" $strPassword2Disabled></td>
      <td><font color=red>$strPassword2Err</font></td>
    </tr>
    <tr>
      <td><input type="submit" name="submit" value="$strSubmit" /></td>
      <td><font color=red>$strSubmitErr</font></td>
    </tr>
  </table>
</form>
END;
}

?>
