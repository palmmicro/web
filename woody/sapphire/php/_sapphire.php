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

function _LayoutLinksSapphirePhoto($bChinese = true)
{
    LayoutTopLeft('_menuSapphirePhoto', true, $bChinese);
}

	$acct = new Account();
//	$acct->AuthAdmin();
?>
