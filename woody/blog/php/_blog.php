<?php
require_once('/php/blogcomments.php');
require_once('/php/layout.php');
require_once('/php/stocklink.php');
require_once('/php/externallink.php');
require_once('/php/ui/link.php');
require_once('/php/ui/blogtable.php');
require_once('/woody/php/_navwoody.php');

function _blogMenuItem($iLevel, $strItem, $bChinese)
{
    if ($bChinese)  $arName = array('ar1688' => 'AR1688', 'entertainment' => '娱乐',          'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro');
    else              $arName = array('ar1688' => 'AR1688', 'entertainment' => 'Entertainment', 'pa1688' => 'PA1688', 'pa3288' => 'PA3288', 'pa6488' => 'PA6488', 'palmmicro' => 'Palmmicro'); 
    
    HtmlMenuItem($arName, $iLevel, $strItem, $bChinese);
}

function NavigateBlogGroup($bChinese)
{
    global $arBlogs;
    
    $iLevel = 2;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'blog', $bChinese);
	NavContinueNewLine();
	_blogMenuItem($iLevel - 1, BLOG_GROUP, $bChinese);
	NavContinueNewLine();
    NavDirFirstLast($arBlogs);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    AcctNoAuth();
    LayoutTopLeft('NavigateBlogGroup', true, $bChinese);
}

function _LayoutBottom($bChinese = true)
{
    EchoBlogComments($bChinese);
    LayoutTailLogin($bChinese);
}


?>
