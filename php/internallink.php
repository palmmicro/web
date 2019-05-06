<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlmember.php');
require_once('sql/sqlvisitor.php');

define('DEFAULT_NAV_DISPLAY', 100);

// ****************************** Internal none-stock link functions *******************************************************

define('ACCT_PATH', '/account/');

function GetDevGuideLink($strPage, $strVer = false, $bChinese = true)
{
    $str = '/woody/blog/entertainment/'.$strPage;
    $str .= UrlGetPhp($bChinese);
    if ($strVer)	$str .= '#'.$strVer;
    return GetInternalLink($str, $bChinese ? '开发记录' : 'Development Record');
}

function GetBlogLink($strBlogId)
{
    $strBlogUri = SqlGetUriByBlogId($strBlogId);
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

function _getIpLink($strTitle, $strIp, $bChinese)
{
    return GetPhpLink(ACCT_PATH.$strTitle, 'ip='.$strIp, $strIp, false, $bChinese);
}

function GetIpLink($strIp, $bChinese)
{
    return _getIpLink('ip', $strIp, $bChinese);
}

function GetVisitorLink($strIp, $bChinese = true)
{
    return _getIpLink(VISITOR_TABLE, $strIp, $bChinese);
}

function GetSpiderVisitorLink($strIp, $bChinese)
{
    return _getIpLink(SPIDER_VISITOR_TABLE, $strIp, $bChinese);
}

function GetLoginLink($strCn, $strUs, $bChinese)
{
    return GetPhpLink(ACCT_PATH.'login', false, $strCn, $strUs, $bChinese);
}

function GetAllCommentLink($strQuery, $bChinese)
{
    return GetPhpLink(ACCT_PATH.'comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

?>
