<?php
require_once('../../../php/layout.php');
require_once('../../../php/bloglink.php');
require_once('../../../php/ui/imagedisp.php');
require_once('../../php/_woodymenu.php');
require_once('_photo.php');

function _menuLoop30Days($bChinese)
{
    $ar30Days = array('blue', 'hat', 'crown', 'yellow', 'leopard'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel + 1, 'image', $bChinese);
	MenuContinueNewLine();
    if ($bChinese)
    {
       	MenuWriteItemLink($iLevel, 'photo30days', URL_CNPHP, '满月艺术照');
    }
    else
    {
       	MenuWriteItemLink($iLevel, 'photo30days', URL_PHP, '30 Days');
    }
	MenuContinueNewLine();
    MenuDirLoop($ar30Days);
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuLoop30Days', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
	LayoutMiaPhotoArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new Account();
?>
