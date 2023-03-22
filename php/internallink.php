<?php

// ****************************** Internal none-stock link functions *******************************************************

define('ACCT_PATH', '/account/');

function GetDevGuideLink($strVer = false, $strLink = '20150818', $bChinese = true)
{
    $str = '/woody/blog/entertainment/'.$strLink;
    $str .= UrlGetPhp($bChinese);
    if ($strVer)	$str .= '#'.$strVer;
    return GetInternalLink($str, $bChinese ? '开发记录' : 'Development Record');
}

function GetMemberLink($strMemberId, $bChinese = true)
{
	if ($strEmail = SqlGetEmailById($strMemberId))
	{
	    if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
	    {
	        $strName = $strEmail;
	    }
	    return GetPhpLink(ACCT_PATH.'profile', 'email='.$strEmail, $strName, false, $bChinese);
	}
    return '';
}

define('ACCOUNT_TOOL_BENFORD', 'Benford\'s Law');
define('ACCOUNT_TOOL_CHI', 'Pearson\'s Chi-squared Test');
define('ACCOUNT_TOOL_CRAMER', 'Cramer\'s Rule');
define('ACCOUNT_TOOL_DICE', 'Dice Captcha');
define('ACCOUNT_TOOL_PHRASE', 'Common Phrase');
define('ACCOUNT_TOOL_EDIT', 'Temporary Test');
define('ACCOUNT_TOOL_IP', 'IP Address Data');
define('ACCOUNT_TOOL_LINEAR', 'Linear Regression');
define('ACCOUNT_TOOL_PRIME', 'Prime Number');
define('ACCOUNT_TOOL_SINAJS', 'Sina Stock Data');

define('ACCOUNT_TOOL_BENFORD_CN', '本福特定律');
define('ACCOUNT_TOOL_CHI_CN', 'Pearson卡方检验');
define('ACCOUNT_TOOL_CRAMER_CN', '解二元一次方程组');
define('ACCOUNT_TOOL_DICE_CN', '骰子验证码');
define('ACCOUNT_TOOL_PHRASE_CN', '个人常用短语');
define('ACCOUNT_TOOL_EDIT_CN', '临时测试');
define('ACCOUNT_TOOL_IP_CN', 'IP地址数据');
define('ACCOUNT_TOOL_LINEAR_CN', '线性回归');
define('ACCOUNT_TOOL_PRIME_CN', '分解质因数');
define('ACCOUNT_TOOL_SINAJS_CN', '新浪股票接口');

function GetAccountToolArray($bChinese)
{
	if ($bChinese)
	{
		$ar = array('benfordslaw' => ACCOUNT_TOOL_BENFORD_CN,
					  'chisquaredtest' => ACCOUNT_TOOL_CHI_CN,
                      'commonphrase' => ACCOUNT_TOOL_PHRASE_CN,
                      'cramersrule' => ACCOUNT_TOOL_CRAMER_CN,
                      'dicecaptcha' => ACCOUNT_TOOL_DICE_CN,
					  'editinput' => ACCOUNT_TOOL_EDIT_CN,
                      'ip' => ACCOUNT_TOOL_IP_CN,
                      'linearregression' => ACCOUNT_TOOL_LINEAR_CN,
                      'primenumber' => ACCOUNT_TOOL_PRIME_CN,
                      'sinajs' => ACCOUNT_TOOL_SINAJS_CN,
                 );
    }
    else
	{
		$ar = array('benfordslaw' => ACCOUNT_TOOL_BENFORD,
					  'chisquaredtest' => ACCOUNT_TOOL_CHI,
                      'commonphrase' => ACCOUNT_TOOL_PHRASE,
                      'cramersrule' => ACCOUNT_TOOL_CRAMER,
                      'dicecaptcha' => ACCOUNT_TOOL_DICE,
					  'editinput' => ACCOUNT_TOOL_EDIT,
					  'ip' => ACCOUNT_TOOL_IP,
                      'linearregression' => ACCOUNT_TOOL_LINEAR,
                      'primenumber' => ACCOUNT_TOOL_PRIME,
                      'sinajs' => ACCOUNT_TOOL_SINAJS,
                 );
    }
	return $ar;
}

function GetAccountToolStr($strPage, $bChinese)
{
    $ar = GetAccountToolArray($bChinese);
	return $ar[$strPage];
}

function _getAccountToolLink($strPage, $bChinese)
{
    return GetPhpLink(ACCT_PATH.$strPage, false, GetAccountToolStr($strPage, $bChinese), false, $bChinese);
}

function GetCommonPhraseLink($bChinese = true)
{
    return _getAccountToolLink('commonphrase', $bChinese);
}

function GetSinaJsLink($bChinese = true)
{
    return _getAccountToolLink('sinajs', $bChinese);
}

function GetSinaQuotesLink($strSinaSymbols)
{
	return GetPhpLink(ACCT_PATH.'sinajs', 'sinajs='.$strSinaSymbols, GetSinaQuotesUrl($strSinaSymbols));
}

function GetLinearRegressionLink($bChinese = true)
{
    return _getAccountToolLink('linearregression', $bChinese);
}

function GetBenfordsLawLink($bChinese = true)
{
    return _getAccountToolLink('benfordslaw', $bChinese);
}

function GetChiSquaredTestLink($bChinese = true)
{
    return _getAccountToolLink('chisquaredtest', $bChinese);
}

function GetCramersRuleLink($bChinese = true)
{
    return _getAccountToolLink('cramersrule', $bChinese);
}

function GetDiceCaptchaLink($bChinese = true)
{
    return _getAccountToolLink('dicecaptcha', $bChinese);
}

function GetEditInputLink($bChinese = true)
{
    return _getAccountToolLink('editinput', $bChinese);
}

function GetPrimeNumberLink($bChinese = true)
{
    return _getAccountToolLink('primenumber', $bChinese);
}

function GetIpAddressLink($bChinese = true)
{
    return _getAccountToolLink('ip', $bChinese);
}

function _getIpLink($strPage, $strIp, $bChinese)
{
    return GetPhpLink(ACCT_PATH.$strPage, 'ip='.$strIp, $strIp, false, $bChinese);
}

function GetIpLink($strIp, $bChinese = true)
{
    return _getIpLink('ip', $strIp, $bChinese);
}

function GetVisitorLink($strIp, $bChinese = true)
{
	return _getIpLink(TABLE_VISITOR, $strIp, $bChinese);
}

function GetAllCommentLink($strQuery, $bChinese)
{
    return GetPhpLink(ACCT_PATH.'comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

?>
