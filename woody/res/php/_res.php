<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function ResMenu($arLoop, $bChinese)
{
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'res', $bChinese);
	MenuContinueNewLine();
    MenuDirLoop($arLoop);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function NavLoopCompany($bChinese)
{
    $arCompanys = array('btbond', 'cateyes'); 
    ResMenu($arCompanys, $bChinese);
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavLoopCompany', true, $bChinese, $bAdsense);
}

   	$acct = new Account();
?>
