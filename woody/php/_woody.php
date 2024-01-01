<?php
require_once('../php/layout.php');
require_once('../php/ui/imagedisp.php');
require_once('_woodymenu.php');

function _menuWoody($bChinese)
{
	MenuBegin();
    MenuSet(GetWoodyMenuArray($bChinese));
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('_menuWoody', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new Account();
?>
