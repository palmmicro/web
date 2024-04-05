<?php
require_once('../../php/layout.php');
require_once('../../php/bloglink.php');
require_once('../../php/ui/imagedisp.php');
require_once('../php/_woodymenu.php');
require_once('../php/_imageaccount.php');

function _menuLoopMyPhoto($bChinese)
{
    $iLevel = 1;
	MenuBegin();
	WoodyMenuItem($iLevel, 'image', $bChinese);
	MenuContinueNewLine();
    MenuDirFirstLast(GetPhotoPageArray(GetMyPhotoYears()));
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoopMyPhoto', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
	LayoutBegin();
	EchoParagraph(GetMyPhotoLinks($bChinese));
	LayoutEnd();
	
	LayoutWoodyMenuArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = $acct->GetPageYear();
	if ($bChinese)	$strYear .= '年相片';
	else				$strYear .= ' Photos';

	return $strYear;
}

function GetMetaDescription($bChinese)
{
	$str = GetTitle($bChinese);
	$str .= $bChinese ? '和相关链接。2012年之前的主题基本上是脚步丈量京郊和车轮丈量美国，2014年后主要都是溜娃。' : ' and related links. Before 2012, mostly traveling the suburbs of Beijing on foot and the United States on wheels. After 2014, mainly about Mia.';
	return CheckMetaDescription($str);
}

   	$acct = new ImageAccount();
?>
