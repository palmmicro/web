<?php
//require_once('url.php');
require_once('debug.php');
require_once('switch.php');
require_once('account.php');
require_once('httplink.php');
require_once('adsense.php');

function _echoLogin($str)
{
	$strDebugLink = '';
    if (AcctIsAdmin())
    {
        $strDebugLink = GetFileDebugLink(DebugGetFile()).' '.GetFileDebugLink(DebugGetTestFile());
    }
    $strServer = UrlGetServer();
    echo <<<END
    <div>
        <p><font color=green>$str</font> $strDebugLink
           <a href="$strServer/ProjectHoneyPot/memorial.php" style="display: none;">metropolitan-tundra</a>
        </p>
    </div>
END;
}

function VisitorLogin($bChinese)
{
	SwitchSetSess();
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
	    $strRegisterLink = GetPhpLink('/account/register', $bChinese, '注册', 'register');
		if ($bChinese)
		{
		    _echoLogin('更多选项? 请先'.$strLoginLink.'或者'.$strRegisterLink.'.');
		}
		else
		{
		    _echoLogin('More options? Please '.$strLoginLink.' or '.$strRegisterLink.' account.');
		}
	}
	
	AdsenseCompanyAds();
//	AdsenseSearchEngine($bChinese);
}

?>
