<?php
require_once('../../php/layout.php');
require_once('../../php/ui/imagedisp.php');
require_once('../php/_woodymenu.php');

function _menuLoopBlogPhoto($bChinese)
{
    $arPhoto = array('photo2006', 'photo2007', 'photo2008', 'photo2009', 'photo2010', 'photo2011', 'photo2012', 'photo2013', 'photo2014', 'photo2015'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'blog', $bChinese);
	WoodyMenuItem($iLevel, 'image', $bChinese);
	MenuContinueNewLine();
    MenuDirFirstLast($arPhoto);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoopBlogPhoto', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
	EchoBlogMenuArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = substr($acct->GetPage(), -4, 4);
	if ($bChinese)	$strYear .= '年网络日志图片';
	else				$strYear .= ' Blog Pictures';

	return $strYear;
}

   	$acct = new TitleAccount();
?>
