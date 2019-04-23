<?php
//require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('account.php');
require_once('httplink.php');

function _echoLogin($str)
{
    $strServer = UrlGetServer();
    echo <<<END
    <div>
        <p><font color=green>$str</font>
           <a href="$strServer/ProjectHoneyPot/memorial.php" style="display: none;">metropolitan-tundra</a>
        </p>
    </div>
END;
}

function VisitorLogin($bChinese)
{
	SwitchSetSess();
    if (UrlIsPalmmicroDomain() == false)	return;
    
	if ($strMemberId = AcctIsLogin()) 
	{
	    $strLink = GetMemberLink($strMemberId, $bChinese);
	    $strLoginLink = GetLoginLink('切换', 'Change', $bChinese);
		if ($bChinese)
		{
		    _echoLogin($strLoginLink.'登录账号'.$strLink);
	    }
	    else
	    {
		    _echoLogin($strLoginLink.' login account '.$strLink);
	    }
	}
	else
	{
	    $strLoginLink = GetLoginLink('登录', 'login', $bChinese);
	    $strRegisterLink = GetPhpLink('/account/register', false, '注册', 'register', $bChinese);
		if ($bChinese)
		{
		    _echoLogin('更多选项? 请先'.$strLoginLink.'或者'.$strRegisterLink.'.');
		}
		else
		{
		    _echoLogin('More options? Please '.$strLoginLink.' or '.$strRegisterLink.' account.');
		}
	}
}

?>
