<?php
require_once('/php/blogcomments.php');
require_once('/php/layout.php');
require_once('/php/nav.php');
require_once('/php/ui/link.php');

function ChishinNavigateBlogGroup($bChinese)
{
    $arBlog = array('20170512', '20170517', '20170523', '20170524', '20180426', '20180429');
    
	NavBegin();
    NavDirFirstLast($arBlog);
    NavEnd();
}

function _ChishinLayoutTopLeft($bChinese)
{
    AcctNoAuth();
    SetSwitchLanguage(false);
    LayoutTopLeft(ChishinNavigateBlogGroup, $bChinese);
}

function _ChishinLayoutBottom($bChinese)
{
    EchoBlogComments($bChinese);
    LayoutTailLogin($bChinese);
}

?>
