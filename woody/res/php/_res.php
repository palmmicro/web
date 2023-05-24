<?php
require_once('../../php/layout.php');
require_once('../php/_woodymenu.php');

function _menuLoopCompany($bChinese)
{
    $arCompany = array('btbond', 'cateyes'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'index', $bChinese);
	MenuContinueNewLine();
    MenuDirLoop($arCompany);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoopCompany', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new Account();
?>
