<?php
require_once('switch.php');
require_once('account.php');
require_once('internallink.php');

function _getLoginLink($strCn, $strUs, $bChinese)
{
    return GetPhpLink(ACCT_PATH.'login', false, $strCn, $strUs, $bChinese);
}

function _echoLogin($str)
{
    echo <<<END
    <div>
        <p><font color=green>$str</font>
        </p>
    </div>
END;
}

function VisitorLogin($bChinese)
{
   	global $acct;

	SwitchSetSess();
	if ($strMemberId = $acct->GetLoginId()) 
	{
	    $strLink = GetMemberLink($strMemberId, $bChinese);
	    $strLoginLink = _getLoginLink('切换', 'Change', $bChinese);
	    $strAccount = $bChinese ? '登录账号' : ' login account ';  
	    _echoLogin($strLoginLink.$strAccount.$strLink);
	}
	else
	{
	    $strLoginLink = _getLoginLink('登录', 'login', $bChinese);
	    $strRegisterLink = GetPhpLink(ACCT_PATH.'register', false, '注册', 'register', $bChinese);
		if ($bChinese)	_echoLogin('更多选项? 请先'.$strLoginLink.'或者'.$strRegisterLink.'.');
		else			    _echoLogin('More options? Please '.$strLoginLink.' or '.$strRegisterLink.' account.');
	}
}

?>
