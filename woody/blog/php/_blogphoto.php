<?php
require_once('../../php/layout.php');
require_once('../../php/bloglink.php');
require_once('../../php/ui/imagedisp.php');
require_once('../php/_woodymenu.php');
require_once('../php/_imageaccount.php');

function _menuLoopBlogPhoto($bChinese)
{
    $iLevel = 1;
	MenuBegin();
	WoodyMenuItem($iLevel, 'blog', $bChinese);
	WoodyMenuItem($iLevel, 'image', $bChinese);
	MenuContinueNewLine();
    MenuDirFirstLast(GetPhotoPageArray(GetBlogPhotoYears()));
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
	LayoutBegin();
	EchoParagraph(GetBlogPhotoLinks($bChinese));
	LayoutEnd();
	
	LayoutBlogMenuArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = $acct->GetPageYear();
	if ($bChinese)	$strYear .= '年网络日志图片';
	else				$strYear .= ' Blog Pictures';

	return $strYear;
}

   	$acct = new ImageAccount();
?>
