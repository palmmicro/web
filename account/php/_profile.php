<?php
require_once('_account.php');
require_once('_editemailform.php');
require_once('/php/stocklink.php');
require_once('/php/sql/sqlstock.php');
require_once('/php/ui/commentparagraph.php');
require_once('/php/ui/fundpurchaseparagraph.php');

define('PROFILE_LOGIN_ACCOUNT', 'Login completed');
define('PROFILE_PASSWORD_CHANGED', 'Password changed');
define('PROFILE_EMAIL_CHANGED', 'Login email updated');
define('PROFILE_NEW_ACCOUNT', 'Registration completed');
define('PROFILE_NEW_PASSWORD', 'New password sent by email');
define('PROFILE_CLOSE_ACCOUNT', 'Account closed');

define('PROFILE_NEW_ACCOUNT_CN', '注册成功');
define('PROFILE_NEW_PASSWORD_CN', '新密码通过电子邮件发送');
define('PROFILE_CLOSE_ACCOUNT_CN', '帐号已经关闭');

function _echoAccountProfileMsg($strMsg, $bChinese)
{
    if ($strMsg == PROFILE_LOGIN_ACCOUNT)
    {
//        if ($bChinese)  $strMsg = '登录成功';
        $strMsg = false;
    }                                                
/*  else if ($strMsg == PROFILE_NEW_ACCOUNT || $strMsg = PROFILE_NEW_ACCOUNT_CN)
    {
    }*/                                                
    else if ($strMsg == PROFILE_PASSWORD_CHANGED)
    {
        if ($bChinese)  $strMsg = '修改密码成功';                  
    }                                                
    else if ($strMsg == PROFILE_EMAIL_CHANGED)
    {
        if ($bChinese)  $strMsg = '登录电子邮件已经更新';                  
    }
    
    if ($strMsg)    EchoParagraph("<font color=blue>$strMsg.</font>");
}

function _echoAccountProfileLinks($bChinese)
{
	if ($bChinese)
	{
		$strLink = "修改<a href=\"passwordcn.php\">密码</a> 更新<a href=\"updateemailcn.php\">登录电子邮件</a> 更新<a href=\"editprofilecn.php\">资料</a>";
	}
	else
	{
		$strLink = "Change <a href=\"password.php\">password</a>, update <a href=\"updateemail.php\">login email</a>, update <a href=\"editprofile.php\">profile</a>";
	}
    EchoParagraph($strLink);
}

function _echoAccountProfileEnglish($member, $strName, $strPhone, $strAddress, $strWeb, $strSignature)
{
    $strIp = GetIpLink($member['ip'], false);
    $strStatus = $member['status'];
	if ($strStatus == '2')		$strStatusDisplay = 'Palmmicro email subscription completed.';
	else if ($strStatus == '1')	$strStatusDisplay = 'No email subscription.';
	else				$strStatusDisplay = 'Account restricted.';
	
    echo <<<END
        <p>Email: <b>{$member['email']}</b>
        <br /><font color=green>$strStatusDisplay</font>
        <br />Name: $strName
        <br />Phone: $strPhone
        <br />Address: $strAddress
        <br />Web: $strWeb
        <br />Register: {$member['register']}
        <br />Last login: {$member['login']}
        <br />Last login IP: $strIp
        <br />Activity: {$member['activity']}
        <br />Signature:
        <br /><b>$strSignature</b>
        </p>
END;
}

function _echoAccountProfileChinese($member, $strName, $strPhone, $strAddress, $strWeb, $strSignature)
{
    $strIp = GetIpLink($member['ip'], true);
    $strStatus = $member['status'];
	if ($strStatus == '2')		$strStatusDisplay = '接收Palmmicro邮件.';
	else if ($strStatus == '1')	$strStatusDisplay = '不接收任何邮件.';
	else				$strStatusDisplay = '帐号受限制.';
	
    echo <<<END
        <p>电子邮件: <b>{$member['email']}</b>
        <br /><font color=green>$strStatusDisplay</font>
        <br />名字: $strName
        <br />电话: $strPhone
        <br />地址: $strAddress
        <br />网址: $strWeb
        <br />注册时间: {$member['register']}
        <br />上次登录时间: {$member['login']}
        <br />上次登录IP地址: $strIp
        <br />活动指数: {$member['activity']}
        <br />签名档
        <br /><b>$strSignature</b>
        </p>
END;
}

function _echoAccountBlogComments($strMemberId, $bChinese)
{
    $strQuery = 'member_id='.$strMemberId;
    $strWhere = SqlWhereFromUrlQuery($strQuery);
    $iTotal = SqlCountBlogComment($strWhere);
    if ($iTotal == 0)   return;

    $str = $bChinese ? '评论' : 'Comment';
    if ($iTotal > MAX_COMMENT_DISPLAY)
    {
        $str .= ' '.GetAllCommentLink($strQuery, $bChinese);
    }
    EchoParagraph($str);
    EchoCommentParagraphs($strMemberId, $strWhere, 0, MAX_COMMENT_DISPLAY, $bChinese);    
}

function _echoAccountFundAmount($strMemberId, $bChinese)
{
    $iTotal = SqlCountFundPurchase($strMemberId);
    if ($iTotal == 0)   return;

    $str = $bChinese ? '申购金额' : 'Fund Amount';
    if ($iTotal > TABLE_COMMON_DISPLAY)
    {
        $str .= ' '.GetPhpLink(STOCK_PATH.'fundpurchaseamount', 'member_id='.$strMemberId, STOCK_DISP_ALL, 'All', $bChinese);
    }
    EchoFundPurchaseParagraph($str, $strMemberId, $bChinese);
}

function EchoAccountProfile($bChinese = true)
{
    global $acct;
    global $strMsg;

    if ($strMsg)    _echoAccountProfileMsg($strMsg, $bChinese);
   	$strMemberId = $acct->GetMemberId();
    if ($strMemberId == false)  return;

    if (AcctIsReadOnly($strMemberId) == false)  _echoAccountProfileLinks($bChinese);
	if ($member = SqlGetMemberById($strMemberId))
	{
	    if ($profile = SqlGetProfileByMemberId($strMemberId))
	    {
	        $strName = $profile['name'];
	        $strPhone = $profile['phone'];
	        $strAddress = $profile['address'];
	        $strWeb = GetHttpLink($profile['web']);
	        $strSignature = nl2br($profile['signature']);
	    }
	    else
	    {
	        $strName = '';
	        $strPhone = '';
	        $strAddress = '';
	        $strWeb = '';
	        $strSignature = '';
	    }
	    
	    if ($bChinese)    _echoAccountProfileChinese($member, $strName, $strPhone, $strAddress, $strWeb, $strSignature);
	    else    	        _echoAccountProfileEnglish($member, $strName, $strPhone, $strAddress, $strWeb, $strSignature);
	}
	
	_echoAccountBlogComments($strMemberId, $bChinese);
	_echoAccountFundAmount($strMemberId, $bChinese);
}                                                         

function _loginAccount($strEmail, $strPassword)
{
	$arErrMsg = array();	// Array to store validation errors

	// Input Validations
	if (!filter_var_email($strEmail))		$arErrMsg[] = ACCT_ERR_EMAIL_INPUT;
	if ($strPassword == '')				$arErrMsg[] = ACCT_ERR_PASSWORD_INPUT;
	if (EditEmailErrOcurred($arErrMsg))	return false;
	
	if (!AcctLogin($strEmail, $_POST['password']))    // Use original password POST 
	{	// Login failed
		$arErrMsg[] = ACCT_ERR_LOGIN_FAILED;
		EditEmailErrOcurred($arErrMsg);
		return false;
	}
	return PROFILE_LOGIN_ACCOUNT;
}

function _registerAccount($strEmail, $strPassword, $strPassword2)
{
	$arErrMsg = array();	// Array to store validation errors

	// Input Validations
	if (filter_var_email($strEmail))
	{	// Check for duplicate login ID
		if (SqlGetIdByEmail($strEmail))
		{
			$arErrMsg[] = ACCT_ERR_EMAIL_REGISTERED;
		}
	}
	else
	{
		$arErrMsg[] = ACCT_ERR_EMAIL_INPUT;
	}
	if ($strPassword == '')					$arErrMsg[] = ACCT_ERR_PASSWORD_INPUT;
	if ($strPassword2 == '')					$arErrMsg[] = ACCT_ERR_PASSWORD2_INPUT;
	if ($strPassword != $strPassword2)    $arErrMsg[] = ACCT_ERR_PASSWORD_MISMATCH;
	if (EditEmailErrOcurred($arErrMsg))	return false;

	if (!SqlInsertMember($strEmail, $_POST['password']))
	{
		return false;
	}
	
	if (UrlIsChinese())
	{
	    $strText = '欢迎';
	    $strSubject = PROFILE_NEW_ACCOUNT_CN;
	}
	else
	{
	    $strText = 'Welcome';
	    $strSubject = PROFILE_NEW_ACCOUNT;
	}
	EmailReport($strText, $strSubject, $strEmail);

	AcctLogin($strEmail, $_POST['password']);
	return $strSubject;
}

function _changePassword($strPassword, $strPassword2)
{
	$member = SqlGetMemberById($_SESSION['SESS_ID']);
	$arErrMsg = array();	// Array to store validation errors

	// Input Validations
	if ($strPassword == '')							        $arErrMsg[] = ACCT_ERR_PASSWORD_INPUT;
	else if (md5($strPassword) == $member['password'])    $arErrMsg[] = ACCT_ERR_PASSWORD_UNCHANGED;
	if ($strPassword2 == '')						            $arErrMsg[] = ACCT_ERR_PASSWORD2_INPUT;
	if ($strPassword != $strPassword2)                     $arErrMsg[] = ACCT_ERR_PASSWORD_MISMATCH;
	if (EditEmailErrOcurred($arErrMsg))	return false;

	if (SqlUpdatePasswordField($member['email'], $_POST['password']))
	{
	    return PROFILE_PASSWORD_CHANGED;
	}
	return false;
}

function _updateLoginEmail($strEmail)
{
	$member = SqlGetMemberById($_SESSION['SESS_ID']);
	$arErrMsg = array();	// Array to store validation errors

	// Input Validations
	if (filter_var_email($strEmail))
	{
		if (SqlGetIdByEmail($strEmail))
		{
			$arErrMsg[] = ACCT_ERR_EMAIL_REGISTERED;
		}
	}
	else
	{
		$arErrMsg[] = ACCT_ERR_EMAIL_INPUT;
	}
	if ($strEmail == $member['email'])    $arErrMsg[] = ACCT_ERR_EMAIL_UNCHANGED;
	if (EditEmailErrOcurred($arErrMsg))	return false;

	if (!SqlUpdateLoginEmail($_SESSION['SESS_ID'], $strEmail))
	{
		return false;
	}
	return PROFILE_EMAIL_CHANGED;
}

function _remindPassword($strEmail)
{
	$arErrMsg = array();	// Array to store validation errors
	if (filter_var_email($strEmail))
	{
		if (!SqlGetIdByEmail($strEmail))
		{
			$arErrMsg[] = ACCT_ERR_EMAIL_UNREGISTERED;
		}
	}
	else
	{
		$arErrMsg[] = ACCT_ERR_EMAIL_INPUT;
	}
	if (EditEmailErrOcurred($arErrMsg))	return false;

	// build a password with current time and user's email
	$strPassword = $strEmail.date(DEBUG_TIME_FORMAT); 
	$strPassword = md5($strPassword);
	$strPassword = substr($strPassword, 16);
	if (!SqlUpdatePasswordField($strEmail, $strPassword))
	{
		return false;
	}
	AcctLogout();

	if (UrlIsChinese())
	{
	    $strText = '你的新密码';
	    $strSubject = PROFILE_NEW_PASSWORD_CN;
	}
	else
	{
	    $strText = 'Your new password';
	    $strSubject = PROFILE_NEW_PASSWORD;
	}
	EmailReport($strText.': '.$strPassword, $strSubject, $strEmail);
	return $strSubject;
}

function _closeAccount($strEmail)
{
	$arErrMsg = array();	// Array to store validation errors
	if (filter_var_email($strEmail))
	{
		if ($strId = SqlGetIdByEmail($strEmail))
		{
			if ($strId != $_SESSION['SESS_ID'])
			{
				if (AcctIsAdmin() == false)
				{
					$arErrMsg[] = ACCT_ERR_UNAUTH_OP;
				}
			}
		}
		else
		{
			$arErrMsg[] = ACCT_ERR_EMAIL_UNREGISTERED;
		}
	}
	else
	{
		$arErrMsg[] = ACCT_ERR_EMAIL_INPUT;
	}
	if (EditEmailErrOcurred($arErrMsg))	return false;

//	AcctLogout();
    AcctDeleteMember($strId);
    
	if (UrlIsChinese())
	{
	    $strText = '再见';
	    $strSubject = PROFILE_CLOSE_ACCOUNT_CN;
	}
	else
	{
	    $strText = 'Goodbye and good luck';
	    $strSubject = PROFILE_CLOSE_ACCOUNT;
	}
	EmailReport($strText, $strSubject, $strEmail);
	return $strSubject;
}

	$strMsg = false;
	$acct = new Account();
	if (isset($_POST['submit']) && isset($_POST['login']))
	{
		$strSubmit = $_POST['submit'];
		unset($_POST['submit']);
		$strEmail = SqlCleanString($_POST['login']);
		$_SESSION['SESS_EMAIL_INPUT'] = $strEmail;
		$strPassword = isset($_POST['password']) ? SqlCleanString($_POST['password']) : '';
		$strPassword2 = isset($_POST['cpassword']) ? SqlCleanString($_POST['cpassword']) : '';
		switch ($strSubmit)
		{
		case EDIT_EMAIL_CLOSE:
		case EDIT_EMAIL_CLOSE_CN:
			if (($strMsg = _closeAccount($strEmail)) == false)    SwitchTo('closeaccount');
			break;

		case EDIT_EMAIL_LOGIN:
		case EDIT_EMAIL_LOGIN_CN:
			if ($strMsg = _loginAccount($strEmail, $strPassword))    SwitchToSess();
			else                                                           SwitchTo('login');
			break;

		case EDIT_EMAIL_PASSWORD:
		case EDIT_EMAIL_PASSWORD_CN:
			if (($strMsg = _changePassword($strPassword, $strPassword2)) == false)    SwitchTo('password');
			break;

		case EDIT_EMAIL_REGISTER:
		case EDIT_EMAIL_REGISTER_CN:
			if ($strMsg = _registerAccount($strEmail, $strPassword, $strPassword2))    SwitchToSess();
			else                                                                			    SwitchTo('register');
			break;

		case EDIT_EMAIL_REMINDER:
		case EDIT_EMAIL_REMINDER_CN:
			if (($strMsg = _remindPassword($strEmail)) == false)    SwitchTo('reminder');
			break;

		case EDIT_EMAIL_UPDATE:
		case EDIT_EMAIL_UPDATE_CN:
			if (($strMsg = _updateLoginEmail($strEmail)) == false)    SwitchTo('updateemail');
			break;
		}
	}
	else
	{
		if ($acct->GetMemberId() == false)
		{
			$acct->Auth();
		}
	}
	
?>
