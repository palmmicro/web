<?php
require_once('/php/layout.php');
require_once('/woody/php/_woodymenu.php');

function _menuSapphirePhoto($bChinese)
{
    $arSapphirePhotos = array('photo2014', 'photo30days', 'photo2015', 'photo2016'); 
    
	MenuBegin();
	WoodyMenuItem(1, 'image', $bChinese);
	MenuContinueNewLine();
    MenuDirFirstLast($arSapphirePhotos);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuSapphirePhoto', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true)
{
    LayoutTail($bChinese, true);
}

function GetTitle($bChinese = true)
{
	global $acct;
	
	$strYear = substr($acct->GetPage(), -4, 4);
	if (is_numeric($strYear))
	{
		if ($bChinese)	$strYear .= '年';
	}
	else
	{
		$strYear = $bChinese ? '满月' : '30 Days';
	}
	
	if ($bChinese)	$str = '林近岚'.$strYear.'相片';
	else				$str = 'Sapphire '.$strYear.' Photos';

	return $str;
}

   	$acct = new TitleAccount();
?>
