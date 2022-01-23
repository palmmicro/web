<?php
require_once('_account.php');
require_once('/php/ui/commentparagraph.php');

function EchoAll($bChinese = true)
{
    global $acct;
    
    if ($str = $acct->GetQuery())
    {
        $strQuery = TABLE_IP.'='.$str;
        $strLink = GetIpLink($str, $bChinese);
    	$strWhere = $acct->BuildWhereByIp($str);
    }
    else if ($str = UrlGetQueryValue('page_id'))
    {
        $strQuery = 'page_id='.$str;
        $strLink = GetBlogLink($acct->GetPageUri($str));
    	$strWhere = $acct->BuildWhereByPage($str);
    }
    else if ($str = $acct->GetMemberId())
    {
//        $strQuery = 'member_id='.$str;
        $strQuery = 'email='.SqlGetEmailById($str);
        $strLink = GetMemberLink($str, $bChinese);
    	$strWhere = $acct->BuildWhereByMember($str);
    }
    else
    {
        $strQuery = false;
        $strLink = '';
        $strWhere = false;
    }

    $iTotal = $acct->CountComments($strWhere);
    $iStart = $acct->GetStart();
    $iNum = $acct->GetNum();
    $strMenuLink = GetMenuLink($strQuery, $iTotal, $iStart, $iNum, $bChinese);
    
    EchoParagraph($strLink.' '.$strMenuLink);
    $acct->EchoComments($strWhere, $iStart, $iNum, $bChinese);
    EchoParagraph($strMenuLink);
}

function GetMetaDescription($bChinese = true)
{
    if ($bChinese)
    {
    	$str = '用户评论集中管理页面. 提供分评论人, 评论链接, IP地址等筛选功能分页显示全部评论, 包括满足条件的编辑和删除链接. 原来仅用于网络日志的评论功能现在扩充到了全部PHP写的网页.';
    }
    else
    {
    	$str = 'Display all blog comments by user, page link and IP address, with related edit and delete links.';
    }
	return CheckMetaDescription($str);
}

function GetTitle($bChinese = true)
{
	return $bChinese ? '用户评论' : 'User Comment';
}

   	$acct = new CommentAccount(TABLE_IP);
?>
