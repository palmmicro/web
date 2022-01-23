<?php
require_once('_blogcomments.php');
//require_once('adsense.php');

function BlogComments()
{
    $bChinese = UrlIsChinese();
    EchoBlogComments($bChinese);
	AdsenseWoodyBlog();
}

   	$acct = new EditCommentAccount();
?>
