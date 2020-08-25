<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function _navBlogType($bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'index', $bChinese);
	NavContinueNewLine();
	
    NavMenuSet(GetBlogMenuArray($bChinese));
	NavContinueNewLine();
	
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft('_navBlogType', true, $bChinese);
}

   	$acct = new Account();
?>
