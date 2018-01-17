<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function NavigateSapphirePhoto($bChinese)
{
    $arSapphirePhotos = array('photo2014', 'photo30days', 'photo2015', 'photo2016'); 
    
	NavBegin();
	WoodyMenuItem(1, 'image', $bChinese);
	NavContinueNewLine();
    NavDirFirstLast($arSapphirePhotos);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutLinksSapphirePhoto($bChinese)
{
    LayoutTopLeft(NavigateSapphirePhoto, $bChinese);
}

	AcctAuth();
	if (!AcctIsAdmin())
	{
        AcctSwitchToLogin();
  	}

?>
