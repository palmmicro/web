<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function ResMenu($arLoop, $bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res', $bChinese);
	NavContinueNewLine();
    NavDirLoop($arLoop);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function NavLoopCompany($bChinese)
{
    $arCompanys = array('btbond', 'cateyes'); 
    ResMenu($arCompanys, $bChinese);
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft('NavLoopCompany', true, $bChinese);
}

   	$acct = new Account();
?>
