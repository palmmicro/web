<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function CateyesMenu($arLoops, $bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel + 1, 'res', $bChinese);
	NavContinueNewLine();
    if ($bChinese)
    {
       	NavWriteItemLink($iLevel, 'cateyes', URL_CNPHP, '猫眼');
    }
    else
    {
       	NavWriteItemLink($iLevel, 'cateyes', URL_PHP, 'Cat Eyes');
    }
	NavContinueNewLine();
    NavDirLoop($arLoops);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function NavLoopCateyes($bChinese)
{
    $arCateyes = array('alexandrite389', 'baozi', 'emerald594'); 
	CateyesMenu($arCateyes, $bChinese);
}

function _LayoutTopLeft($bChinese = true)
{
    LayoutTopLeft('NavLoopCateyes', true, $bChinese);
}

    AcctNoAuth();

?>
