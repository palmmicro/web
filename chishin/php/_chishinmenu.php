<?php
require_once('/php/_blogcomments.php');
require_once('/php/layout.php');
require_once('/php/visitorlogin.php');
require_once('/php/ui/link.php');

function _menuChishinBlogGroup($bChinese)
{
    $arBlog = array('20170512', '20170517', '20170523', '20170524', '20180426', '20180429', '20180504', '20180508', '20180512', '20180513', '20180515', '20180519', '20180521');
    
	MenuBegin();
    MenuDirFirstLast($arBlog);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuChishinBlogGroup');
}

function _LayoutBottom($bChinese = true)
{
    EchoBlogComments($bChinese);
    VisitorLogin($bChinese);
    LayoutTail($bChinese, true);
}

   	$acct = new EditCommentAccount();
?>
