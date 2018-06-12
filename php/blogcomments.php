<?php
require_once('account.php');
require_once('visitorlogin.php');
require_once('adsense.php');
require_once('ui/commentparagraph.php');
require_once('/account/php/_editcommentform.php');

function _echoPreviousComments($strBlogId, $strMemberId, $bChinese)
{
    $strQuery = 'blog_id='.$strBlogId;
    $strWhere = SqlWhereFromUrlQuery($strQuery);
    $iTotal = SqlCountBlogComment($strWhere);
    if ($iTotal == 0)
    {
	    $str = $bChinese ? '本页面尚无任何评论.' : 'No comments for this page yet.';
    }
    else
    {
		$str = $bChinese ? '本页面评论:' : ' Comments for this page:';
    }
    $str = "<font color=blue><em>$str</em></font>";
    
    if ($iTotal > MAX_COMMENT_DISPLAY)
	{
	    $str .= ' '.GetAllCommentLink($strQuery, $bChinese);
	}
	
	echo '<div>';
	EchoParagraph($str);
    if ($iTotal > 0)    EchoCommentParagraphs($strMemberId, $strWhere, 0, MAX_COMMENT_DISPLAY, $bChinese);    
    echo '</div>';
}

function EchoBlogComments($bChinese)
{
//    $strMemberId = AcctNoAuth();
    $strMemberId = AcctIsLogin();
	if ($strBlogId = AcctGetBlogId())
	{	
		_echoPreviousComments($strBlogId, $strMemberId, $bChinese);
		if ($strMemberId) 
		{
	        if ($bChinese)
	        {
	            $strSubmit = BLOG_COMMENT_NEW_CN;
	        }
	        else
	        {
	            $strSubmit = BLOG_COMMENT_NEW;
	        }
	        EditCommentForm($strSubmit);
	    }
	}
}

function BlogComments()
{
    $bChinese = UrlIsChinese();
    AcctNoAuth();
    EchoBlogComments($bChinese);
	VisitorLogin($bChinese);
	AdsenseCompanyAds();
//	AdsenseSearchEngine($bChinese);
}


?>
