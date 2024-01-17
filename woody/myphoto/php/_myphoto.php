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

   	$acct = new ImageAccount();
?>
