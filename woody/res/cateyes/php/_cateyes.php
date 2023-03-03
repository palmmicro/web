<?php
require_once('../../../php/layout.php');
require_once('../../php/_woodymenu.php');

function _menuLoopCateyes($bChinese)
{
    $arCateyes = array('alexandrite389', 'baozi', 'emerald594'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel + 1, 'res', $bChinese);
	MenuContinueNewLine();
    if ($bChinese)
    {
       	MenuWriteItemLink($iLevel, 'cateyes', URL_CNPHP, '猫眼');
    }
    else
    {
       	MenuWriteItemLink($iLevel, 'cateyes', URL_PHP, 'Cat Eyes');
    }
	MenuContinueNewLine();
    MenuDirLoop($arCateyes);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoopCateyes', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new Account();
?>
