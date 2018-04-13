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

function _LaosunLayoutTopLeft($bChinese)
{
    AcctNoAuth();
    LayoutTopLeft(LaosunNavigateBlogGroup, $bChinese);
}

function _LaosunLayoutBottom($bChinese)
{
    EchoBlogComments($bChinese);
    LayoutTailLogin($bChinese);
}

?>
