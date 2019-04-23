<?php
require_once('/php/blogcomments.php');
require_once('/php/layout.php');
require_once('/php/nav.php');

function LaosunNavigateBlogGroup($bChinese)
{
    $arBlog = array('20170624');
    
	NavBegin();
    NavDirFirstLast($arBlog);
    NavEnd();
}

function _LaosunLayoutTopLeft()
{
    AcctNoAuth();
    LayoutTopLeft(LaosunNavigateBlogGroup);
}

function _LaosunLayoutBottom()
{
    EchoBlogComments();
    LayoutTailLogin();
}

?>
