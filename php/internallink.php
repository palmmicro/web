<?php
require_once('url.php');

// ****************************** Internal none-stock link functions *******************************************************

define ('ACCT_PATH', '/account/');

function AcctGetBlogLink($strBlogId)
{
    $strBlogUri = SqlGetUriByBlogId($strBlogId);
    if ($strBlogUri)
    {
        return UrlGetLink($strBlogUri, $strBlogUri);
    }
    return '';
}

function AcctGetMemberLink($strMemberId, $bChinese)
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

function AcctGetIpLink($strIp, $bChinese)
{
    return _getIpLink('ip', $strIp, $bChinese);
}

function AcctGetVisitorLink($strIp, $bChinese)
{
    return _getIpLink(VISITOR_TABLE, $strIp, $bChinese);
}

function AcctGetSpiderVisitorLink($strIp, $bChinese)
{
    return _getIpLink(SPIDER_VISITOR_TABLE, $strIp, $bChinese);
}

function AcctGetLoginLink($strCn, $strUs, $bChinese)
{
    return UrlBuildPhpLink(ACCT_PATH.'login', false, $strCn, $strUs, $bChinese);
}

function AcctGetAllCommentLink($strQuery, $bChinese)
{
    return UrlBuildPhpLink(ACCT_PATH.'comment', $strQuery, '全部评论', 'All Comment', $bChinese);
}

?>
