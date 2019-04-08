<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function GetMenuArray()
{
    return array('adr' => 'ADR工具',
                      'chinaetf' => 'A股ETF',
                      'goldetf' => '黄金ETF',
                      'gradedfund' => '分级基金',
                      'lof' => 'LOF工具',
                      'lofhk' => '香港LOF',
                     );
}

function _menuItemClass($iLevel, $strClass, $bChinese)
{
    $iLevel --;
    $ar = GetMenuArray();
    $strDisp = $ar[$strClass];
   	NavWriteItemLink($iLevel, $strClass, UrlGetPhp($bChinese), $strDisp);
    NavContinueNewLine();
}

function ResMenu($arLoop, $bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res', $bChinese);
	NavContinueNewLine();

    $arFirst = array('adr' => 'ach',
                      'chinaetf' => 'sh510300',
                      'goldetf' => 'sh518800',
                      'gradedfund' => 'sh502004',
                      'lof' => 'sh501018',
                      'lofhk' => 'sh501021',
                     );
    _menuItemClass($iLevel, array_search($arLoop[0], $arFirst), $bChinese);

    NavDirLoop($arLoop);
//	NavContinueNewLine();
//    NavSwitchLanguage($bChinese);
    NavEnd();
}

function NavStockSoftware($bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res', $bChinese);
	NavContinueNewLine();
    NavMenuSet(GetMenuArray());
//	NavContinueNewLine();
//    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavStockSoftware, $bChinese);
}

function NavLoopGradedFund($bChinese)
{
    ResMenu(GradedFundGetSymbolArray(), $bChinese);
}

function _LayoutGradedFundTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopGradedFund, $bChinese);
}

function NavLoopGoldEtf($bChinese)
{
    ResMenu(GoldEtfGetSymbolArray(), $bChinese);
}

function _LayoutGoldEtfTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopGoldEtf, $bChinese);
}

function NavLoopChinaEtf($bChinese)
{
    ResMenu(ChinaEtfGetSymbolArray(), $bChinese);
}

function _LayoutChinaEtfTopLeft()
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopChinaEtf);
}

function NavLoopLof($bChinese)
{
    ResMenu(LofGetSymbolArray(), $bChinese);
}

function _LayoutLofTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopLof, $bChinese);
}

function NavLoopLofHk($bChinese)
{
    ResMenu(LofHkGetSymbolArray(), $bChinese);
}

function _LayoutLofHkTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopLofHk, $bChinese);
}

function NavLoopAdr($bChinese)
{
    ResMenu(AdrGetSymbolArray(), $bChinese);
}

function _LayoutAdrTopLeft($bChinese = true)
{
    SetSwitchLanguage();
    LayoutTopLeft(NavLoopAdr, $bChinese);
}

?>
