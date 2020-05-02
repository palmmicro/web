<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function _getEditEmailSubmit($strTitle, $bChinese)
{
    if ($bChinese)
    {
        $ar = array('closeaccount' => EDIT_EMAIL_CLOSE_CN,
                      'login' => EDIT_EMAIL_LOGIN_CN,
                      'password' => EDIT_EMAIL_PASSWORD_CN,
                      'register' => EDIT_EMAIL_REGISTER_CN,
                      'reminder' => EDIT_EMAIL_REMINDER_CN,
                      'updateemail' => EDIT_EMAIL_UPDATE_CN,
                     );
    }
    else
    {
         $ar = array('closeaccount' => EDIT_EMAIL_CLOSE,
                      'login' => EDIT_EMAIL_LOGIN,
                      'password' => EDIT_EMAIL_PASSWORD,
                      'register' => EDIT_EMAIL_REGISTER,
                      'reminder' => EDIT_EMAIL_REMINDER,
                      'updateemail' => EDIT_EMAIL_UPDATE,
                     );
    }
	return $ar[$strTitle];
}

function EchoAll($bChinese = true)
{
	$strTitle = UrlGetTitle();
	switch ($strTitle)
	{
	case 'closeaccount':
		$str = $bChinese ? '关闭帐号后所有跟此帐号相关的数据都会被删除, 并且不可恢复.' : 'After account is closed, all related data is deleted and can not be recovered.';
		break;

	case 'login':
		$str = $bChinese ? '欢迎回来! 你可以<a href="registercn.php">注册</a>新帐号. 忘记密码了? 点击<a href="remindercn.php">这里</a>.' 
                       		: 'Welcome back! You can <a href="register.php">register</a> here. Forgot password? Click <a href="reminder.php">here</a>.';
		break;
		
	case 'password':
		$str = '';
		break;
		
	case 'register':
		$str = $bChinese ? '欢迎注册! 除非你主动要求, 否则我们不会给你发任何邮件.' : 'Welcome! We will NOT send you any email unless it is required by yourself.';
		break;
		
	case 'reminder':
		$str = $bChinese ? '新的密码通过电子邮件发送.' : 'New password will be sent by email.';
		break;

	case 'updateemail':
		$str = $bChinese ? '我们通过登录电子邮件联系你, 务必确认能收到这个地址的电子邮件.' : 'Login email is used to contact you, make sure you can receive email from it.';
		break;
    }
   	EchoParagraph($str);
    EditEmailForm(_getEditEmailSubmit($strTitle, $bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$strTitle = UrlGetTitle();
    $strSubmit = _getEditEmailSubmit($strTitle, $bChinese);
   	$str = $bChinese ? "本中文页面文件跟/account/php/_editemail.php和/account/php/_editemailform.php一起配合完成{$strSubmit}的功能."
						: "This English web page works together with /account/php/_editemail.php and /account/php/_editemailform.php to $strSubmit.";
	switch ($strTitle)
	{
	case 'login':
		$str .= $bChinese ? '在过去12个月中没有登录过的账户会被自动清除.' : '';
		break;
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = _getEditEmailSubmit(UrlGetTitle(), $bChinese);
    echo $str;
}

   	$acct = new Account();
	$strTitle = UrlGetTitle();
	switch ($strTitle)
	{
	case 'login':
	case 'register':
	case 'reminder':
		break;
		
	default:
		$acct->Auth();
		break;
    }
?>
