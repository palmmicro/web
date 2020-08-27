<?php
require_once('/php/_blogcomments.php');
//require_once('/php/layout.php');
require_once('/php/stocklink.php');
require_once('/php/externallink.php');
require_once('/php/ui/link.php');
require_once('/php/ui/blogtable.php');
require_once('/woody/php/_navwoody.php');

function NavigateBlogGroup($bChinese)
{
    global $arBlogs;
    
    $iLevel = 2;
	$ar = GetBlogMenuArray($bChinese);
    
	NavBegin();
	WoodyMenuItem($iLevel, 'index', $bChinese);
	NavContinueNewLine();
	NavWriteItemLink($iLevel - 1, BLOG_GROUP, UrlGetPhp($bChinese), $ar[BLOG_GROUP]);
	NavContinueNewLine();
    NavDirFirstLast($arBlogs);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft('NavigateBlogGroup', true, $bChinese);
}

function _LayoutBottom($bChinese = true)
{
    EchoBlogComments($bChinese);
    LayoutTailLogin($bChinese);
}

   	$acct = new EditCommentAccount();
?>
