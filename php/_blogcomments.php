<?php
//require_once('account.php');
require_once('layout.php');
require_once('ui/commentparagraph.php');
require_once('/account/php/_editcommentform.php');

function EchoBlogComments($bChinese = true)
{
    global $acct;
    
	$page_sql = $acct->GetPageSql();
	$strBlogId = $page_sql->GetKeyId();
	
    $strQuery = 'page_id='.$strBlogId;
    $strWhere = SqlWhereFromUrlQuery($strQuery);
    
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
	
	echo '<div>';
    EchoCommentLinkParagraph($str, $strQuery, $bChinese);
    if ($iTotal > 0)    $acct->EchoComments($strWhere, 0, MAX_COMMENT_DISPLAY, $bChinese);    
    echo '</div>';

	if ($strMemberId = $acct->GetLoginId()) 
	{
        EditCommentForm(($bChinese ? BLOG_COMMENT_NEW_CN : BLOG_COMMENT_NEW), $strMemberId);
    }
}


?>
