<?php
require_once('httplink.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlmember.php');
require_once('sql/sqlvisitor.php');

// ****************************** Internal none-stock link functions *******************************************************

define('ACCT_PATH', '/account/');

function GetDevGuideLink($strLink, $strVer = false, $bChinese = true)
{
    $str = '/woody/blog/entertainment/'.$strLink;
    $str .= UrlGetPhp($bChinese);
    if ($strVer)	$str .= '#'.$strVer;
    return GetInternalLink($str, $bChinese ? '开发记录' : 'Development Record');
}

function GetBlogLink($strBlogUri)
{
    if ($strBlogUri)
    {
        return GetInternalLink($strBlogUri, $strBlogUri);
    }
    return '';
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

define('ACCOUNT_TOOL_BENFORD_CN', '本福特定律');
define('ACCOUNT_TOOL_CHI_CN', 'Pearson卡方检验');
define('ACCOUNT_TOOL_CRAMER_CN', '解二元一次方程组');
define('ACCOUNT_TOOL_DICE_CN', '骰子验证码');
define('ACCOUNT_TOOL_PHRASE_CN', '个人常用短语');
define('ACCOUNT_TOOL_EDIT_CN', '临时测试');
define('ACCOUNT_TOOL_IP_CN', 'IP地址数据');
define('ACCOUNT_TOOL_LINEAR_CN', '线性回归');
define('ACCOUNT_TOOL_PRIME_CN', '分解质因数');

define('PAGE_TOOL_EDIT', 'editinput');

function GetAccountToolArray($bChinese)
{
	if ($bChinese)
	{
		$ar = array('benfordslaw' => ACCOUNT_TOOL_BENFORD_CN,
					  'chisquaredtest' => ACCOUNT_TOOL_CHI_CN,
                      TABLE_COMMON_PHRASE => ACCOUNT_TOOL_PHRASE_CN,
                      'cramersrule' => ACCOUNT_TOOL_CRAMER_CN,
                      'dicecaptcha' => ACCOUNT_TOOL_DICE_CN,
					  PAGE_TOOL_EDIT => ACCOUNT_TOOL_EDIT_CN,
                      TABLE_IP => ACCOUNT_TOOL_IP_CN,
                      'linearregression' => ACCOUNT_TOOL_LINEAR_CN,
                      TABLE_PRIME_NUMBER => ACCOUNT_TOOL_PRIME_CN,
                 );
    }
    else
	{
		$ar = array('benfordslaw' => ACCOUNT_TOOL_BENFORD,
					  'chisquaredtest' => ACCOUNT_TOOL_CHI,
                      TABLE_COMMON_PHRASE => ACCOUNT_TOOL_PHRASE,
                      'cramersrule' => ACCOUNT_TOOL_CRAMER,
                      'dicecaptcha' => ACCOUNT_TOOL_DICE,
					  PAGE_TOOL_EDIT => ACCOUNT_TOOL_EDIT,
					  TABLE_IP => ACCOUNT_TOOL_IP,
                      'linearregression' => ACCOUNT_TOOL_LINEAR,
                      TABLE_PRIME_NUMBER => ACCOUNT_TOOL_PRIME,
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
    return _getAccountToolLink(TABLE_COMMON_PHRASE, $bChinese);
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
    return _getAccountToolLink(PAGE_TOOL_EDIT, $bChinese);
}

function GetPrimeNumberLink($bChinese = true)
{
    return _getAccountToolLink(TABLE_PRIME_NUMBER, $bChinese);
}

function GetIpAddressLink($bChinese = true)
{
    return _getAccountToolLink(TABLE_IP, $bChinese);
}

function _getIpLink($strPage, $strIp, $bChinese)
{
    return GetPhpLink(ACCT_PATH.$strPage, 'ip='.$strIp, $strIp, false, $bChinese);
}

function GetIpLink($strIp, $bChinese = true)
{
    return _getIpLink(TABLE_IP, $strIp, $bChinese);
}

function GetVisitorLink($strIp = false, $bChinese = true)
{
	if ($strIp)
	{
		return _getIpLink(TABLE_VISITOR, $strIp, $bChinese);
	}
	return GetPhpLink(ACCT_PATH.TABLE_VISITOR, false, '访问统计', 'Visitor', $bChinese);
}

function GetAllCommentLink($strQuery, $bChinese)
{
    return GetPhpLink(ACCT_PATH.'comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

?>
