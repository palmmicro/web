<?php
require_once('../../../php/layout.php');
require_once('../../../php/bloglink.php');
require_once('../../../php/ui/imagedisp.php');
require_once('../../php/_woodymenu.php');
require_once('_photo.php');

function _menuLoop30Days($bChinese)
{
	$strDisplay = GetMia30DaysDisplay($bChinese);
	$ar30Days = array_keys(Get30DaysMenuArray($bChinese));		// array('blue', 'hat', 'crown', 'yellow', 'leopard'); 
    $iLevel = 1;
    
	MenuBegin();
	WoodyMenuItem($iLevel + 1, 'image', $bChinese);
	MenuContinueNewLine();
   	MenuWriteItemLink($iLevel, 'photo30days', UrlGetPhp($bChinese), $strDisplay);
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
	LayoutBegin();
	EchoParagraph(GetPhotoDirLink(20141211, $bChinese, false).' '.GetMia30DaysLink($bChinese).' '.GetCategoryLinks(Get30DaysMenuArray($bChinese), PATH_30DAYS, $bChinese));
	LayoutEnd();

	LayoutMiaPhotoArray($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

   	$acct = new TitleAccount();
?>
