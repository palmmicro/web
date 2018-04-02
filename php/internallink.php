<?php
require_once('url.php');
require_once('sql/sqlblog.php');
require_once('sql/sqlmember.php');
require_once('sql/sqlvisitor.php');

// ****************************** Internal none-stock link functions *******************************************************

define ('ACCT_PATH', '/account/');

function GetBlogLink($strBlogId)
{
    $strBlogUri = SqlGetUriByBlogId($strBlogId);
    if ($strBlogUri)
    {
        return UrlGetLink($strBlogUri, $strBlogUri);
    }
    return '';
}

function GetMemberLink($strMemberId, $bChinese)
{
	if ($strEmail = SqlGetEmailById($strMemberId))
	{
	    if (($strName = SqlGetNameByMemberId($strMemberId)) == false)
	    {
	        $strName = $strEmail;
	    }
	    return UrlGetPhpLink(ACCT_PATH.'profile', 'email='.$strEmail, $strName, $bChinese);
	}
    return '';
}

function _getIpLink($strTitle, $strIp, $bChinese)
{
    return UrlGetPhpLink(ACCT_PATH.$strTitle, 'ip='.$strIp, $strIp, $bChinese);
}

function GetIpLink($strIp, $bChinese)
{
    return _getIpLink('ip', $strIp, $bChinese);
}

function GetVisitorLink($strIp, $bChinese)
{
    return _getIpLink(VISITOR_TABLE, $strIp, $bChinese);
}

function GetSpiderVisitorLink($strIp, $bChinese)
{
    return _getIpLink(SPIDER_VISITOR_TABLE, $strIp, $bChinese);
}

function GetLoginLink($strCn, $strUs, $bChinese)
{
    return UrlBuildPhpLink(ACCT_PATH.'login', false, $strCn, $strUs, $bChinese);
}

function GetAllCommentLink($strQuery, $bChinese)
{
    return UrlBuildPhpLink(ACCT_PATH.'comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

?>
