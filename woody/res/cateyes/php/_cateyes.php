<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function CateyesMenu($arLoops, $bChinese)
{
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
    MenuDirLoop($arLoops);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function NavLoopCateyes($bChinese)
{
    $arCateyes = array('alexandrite389', 'baozi', 'emerald594'); 
	CateyesMenu($arCateyes, $bChinese);
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavLoopCateyes', true, $bChinese, $bAdsense);
}

   	$acct = new Account();
?>
