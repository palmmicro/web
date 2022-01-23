<?php
require_once('/php/layout.php');
require_once('/woody/php/_woodymenu.php');

function _menuBlogType($bChinese)
{
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'index', $bChinese);
	MenuContinueNewLine();
	
    MenuSet(GetBlogMenuArray($bChinese));
	MenuContinueNewLine();
	
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuBlogType', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true)
{
    LayoutTail($bChinese, true);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strPage = $acct->GetPage();
	$ar = GetBlogMenuArray($bChinese);
	$str = $ar[$strPage];
	if ($bChinese)	$str .= '日志';
	else				$str .= ' Blogs';

	return $str;
}

   	$acct = new TitleAccount();
?>
