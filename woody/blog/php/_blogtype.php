<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function _navBlogType($bChinese)
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
    LayoutTopLeft('_navBlogType', true, $bChinese, $bAdsense);
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
