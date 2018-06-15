<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function _navLoopBlogPhoto($bChinese)
{
    $arPhoto = array('photo2006', 'photo2007', 'photo2008', 'photo2009', 'photo2010', 'photo2011', 'photo2012', 'photo2013', 'photo2014', 'photo2016', 'photo2017'); 
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'blog', $bChinese);
	WoodyMenuItem($iLevel, 'image', $bChinese);
	NavContinueNewLine();
    NavDirFirstLast($arPhoto);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft(_navLoopBlogPhoto, $bChinese);
}

    AcctNoAuth();

?>
