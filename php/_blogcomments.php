<?php
require_once('layout.php');
require_once('visitorlogin.php');
require_once('_editcommentform.php');

function EchoBlogComments($bChinese = true)
{
    global $acct;
    
	$strBlogId = $acct->GetPageId();
   	$strWhere = $acct->BuildWhereByPage($strBlogId);
    
    $iTotal = $acct->CountComments($strWhere);
    $strQuery = false;
    if ($iTotal == 0)
    {
	    $str = $bChinese ? '本页面尚无任何评论.' : 'No comments for this page yet.';
    }
    else
    {
		$str = $bChinese ? '本页面评论' : ' Comments for this page';
		$str .= ' '.strval($iTotal);
		if ($iTotal > MAX_COMMENT_DISPLAY)	$strQuery = 'page_id='.$strBlogId;
    }
	
	LayoutBegin();
    EchoCommentLinkParagraph($str, $strQuery, $bChinese);
    if ($iTotal > 0)    $acct->EchoComments($strWhere, 0, MAX_COMMENT_DISPLAY, $bChinese);    
	LayoutEnd();

	if ($acct->GetLoginId()) 
	{
        $acct->EditCommentForm($bChinese ? BLOG_COMMENT_NEW_CN : BLOG_COMMENT_NEW);
    }
    VisitorLogin($bChinese);
}

?>
