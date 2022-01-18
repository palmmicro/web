<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function NavLoopBtbond($bChinese)
{
    $arBtbonds = array('coinwifi'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel + 1, 'res', $bChinese);
	MenuContinueNewLine();
    if ($bChinese)
    {
       	MenuWriteItemLink($iLevel, 'btbond', URL_CNPHP, '藍邦科技');
    }
    else
    {
       	MenuWriteItemLink($iLevel, 'btbond', URL_PHP, 'Btbond');
    }
	MenuContinueNewLine();
    MenuDirLoop($arBtbonds);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavLoopBtbond', true, $bChinese, $bAdsense);
}

   	$acct = new Account();
?>
