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
        $page_sql = $acct->GetPageSql();
        $strLink = GetBlogLink($page_sql, $str);
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
    $strNavLink = GetNavLink($strQuery, $iTotal, $iStart, $iNum, $bChinese);
    
    EchoParagraph($strLink.' '.$strNavLink);
    $acct->EchoComments($strWhere, $iStart, $iNum, $bChinese);
    EchoParagraph($strNavLink);
}

function EchoMetaDescription($bChinese = true)
{
    if ($bChinese)
    {
    	$str = '用户评论集中管理页面. 提供分评论人, 评论链接, IP地址等筛选功能分页显示全部评论, 包括满足条件的编辑和删除链接. 原来仅用于网络日志的评论功能现在扩充到了全部PHP写的网页.';
    }
    else
    {
    	$str = 'Display all blog comments by user, page link and IP address, with related edit and delete links.';
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = $bChinese ? '用户评论' : 'User Comment';
    echo $str;
}

   	$acct = new CommentAccount(TABLE_IP);
?>
