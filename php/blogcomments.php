<?php
require_once('_blogcomments.php');
require_once('visitorlogin.php');
require_once('adsense.php');

function BlogComments()
{
    $bChinese = UrlIsChinese();
    EchoBlogComments($bChinese);
	VisitorLogin($bChinese);
	AdsenseWoodyBlog();
}

   	$acct = new AcctStart();
?>
