<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function NavLoop30Days($bChinese)
{
    $ar30Days = array('blue', 'hat', 'crown', 'yellow', 'leopard'); 
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel + 1, 'image', $bChinese);
	NavContinueNewLine();
    if ($bChinese)
    {
       	NavWriteItemLink($iLevel, 'photo30days', URL_CNPHP, '满月艺术照');
    }
    else
    {
       	NavWriteItemLink($iLevel, 'photo30days', URL_PHP, '30 Days');
    }
	NavContinueNewLine();
    NavDirLoop($ar30Days);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft('NavLoop30Days', true, $bChinese);
}

   	$acct = new Account();
?>
