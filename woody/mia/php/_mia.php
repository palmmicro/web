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

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = $acct->GetPageYear();
	if ($bChinese)	$str = '林近岚'.$strYear.'年相片';
	else				$str = 'Mia '.$strYear.' Photos';

	return $str;
}

function GetMetaDescription($bChinese)
{
	$str = GetTitle($bChinese);
	$str .= $bChinese ? '和相关链接。从各种来源的相片中精挑细选，也不知道以后她看了是否满意，估计还是恨不得网站被屏蔽的的可能性居多。' : ' and related links. Although I spent a lot of time on it, I guess she might hate those in the future.';
	return CheckMetaDescription($str);
}

   	$acct = new ImageAccount();
?>
