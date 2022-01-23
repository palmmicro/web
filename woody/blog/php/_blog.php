<?php
require_once('/php/_blogcomments.php');
require_once('/php/stocklink.php');
require_once('/php/externallink.php');
require_once('/php/ui/link.php');
require_once('/php/ui/blogtable.php');
require_once('/woody/php/_woodymenu.php');

function _menuBlogGroup($bChinese)
{
    global $arBlogs;
    
    $iLevel = 2;
	$ar = GetBlogMenuArray($bChinese);
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'index', $bChinese);
	MenuContinueNewLine();
	MenuWriteItemLink($iLevel - 1, BLOG_GROUP, UrlGetPhp($bChinese), $ar[BLOG_GROUP]);
	MenuContinueNewLine();
    MenuDirFirstLast($arBlogs);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuBlogGroup', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true)
{
    EchoBlogComments($bChinese);
    LayoutTail($bChinese, true);
}

   	$acct = new EditCommentAccount();
?>
