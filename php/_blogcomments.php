<?php
require_once('layout.php');
require_once('visitorlogin.php');
require_once('/account/php/_editcommentform.php');

function EchoBlogComments($bChinese = true)
{
    global $acct;
    
	$strBlogId = $acct->GetPageId(UrlGetUri());
    $strQuery = 'page_id='.$strBlogId;
   	$strWhere = $acct->BuildWhereByPage($strBlogId);
    
    $iTotal = $acct->CountComments($strWhere);
    if ($iTotal == 0)
    {
	    $str = $bChinese ? '本页面尚无任何评论.' : 'No comments for this page yet.';
    }
    else
    {
		$str = $bChinese ? '本页面评论' : ' Comments for this page';
		$str .= ' '.strval($iTotal);
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
