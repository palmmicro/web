<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function NavLoopBtbond($bChinese)
{
    $arBtbonds = array('coinwifi'); 
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel + 1, 'res', $bChinese);
	NavContinueNewLine();
    if ($bChinese)
    {
       	NavWriteItemLink($iLevel, 'btbond', URL_CNPHP, '藍邦科技');
    }
    else
    {
       	NavWriteItemLink($iLevel, 'btbond', URL_PHP, 'Btbond');
    }
	NavContinueNewLine();
    NavDirLoop($arBtbonds);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavLoopBtbond', true, $bChinese, $bAdsense);
}

   	$acct = new Account();
?>
