<?php
require_once('../../php/layout.php');
require_once('../../php/bloglink.php');
require_once('../../php/ui/imagedisp.php');
require_once('../php/_woodymenu.php');
require_once('../php/_imageaccount.php');

function _menuMiaPhoto($bChinese)
{
	MenuBegin();
	WoodyMenuItem(1, 'image', $bChinese);
	MenuContinueNewLine();
    MenuDirFirstLast(GetPhotoPageArray(GetMiaPhotoYears()));
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuMiaPhoto', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
	LayoutMiaPhotoArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new ImageAccount();
?>
