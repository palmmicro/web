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
	if (is_numeric($strYear))
	{
		if ($bChinese)	$strYear .= '年';
	}
	else
	{
		switch ($strYear)
		{
		case '30days':
			$strYear = $bChinese ? '满月' : '30 Days';
			break;
		}
	}
	
	if ($bChinese)	$str = '林近岚'.$strYear.'相片';
	else				$str = 'Mia '.$strYear.' Photos';

	return $str;
}

   	$acct = new ImageAccount();
?>
