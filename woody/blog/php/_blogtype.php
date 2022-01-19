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

function EchoTitle($bChinese = true)
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
	$ar = GetBlogMenuArray($bChinese);
	$str = $ar[$strTitle];
	if ($bChinese)	$str .= '日志';
	else				$str .= ' Blogs';

    echo $str;
}

   	$acct = new TitleAccount();
?>
