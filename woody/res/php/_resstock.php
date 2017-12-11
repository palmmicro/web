<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function GetMenuArray($bChinese)
{
    if ($bChinese)
    {
        return array('adr' => 'ADR工具',
                      'future' => '期货ETF',
                      'goldetf' => '黄金ETF',
                      'gradedfund' => '分级基金',
                      'lof' => 'LOF工具',
                      'lofhk' => '香港LOF',
                      'pairtrading' => '配对交易',
                     );
    }
    else
    {
         return array('adr' => 'ADR Tools',
                      'future' => 'Future ETF',
                      'goldetf' => 'Gold ETF',
                      'gradedfund' => 'Graded Fund',
                      'lof' => 'LOF Tools',
                      'lofhk' => 'HK LOF',
                      'pairtrading' => 'Pair Trading',      
                     );
    }
}

function _menuItemClass($iLevel, $strClass, $bChinese)
{
    $iLevel --;
    $ar = GetMenuArray($bChinese);
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
	if (strlen($arLoop[0]) > 3 && substr($arLoop[0], 0, 3) == 'adr')
	{
	    _menuItemClass($iLevel, 'adr', $bChinese);
	}
	else if (strlen($arLoop[0]) > 6 && substr($arLoop[0], 0, 6) == 'future')
	{
	    _menuItemClass($iLevel, 'future', $bChinese);
	}
	else if ($arLoop[0] == 'sh501018')
	{
	    _menuItemClass($iLevel, 'lof', $bChinese);
	}
	else if ($arLoop[0] == 'sh501021')
	{
	    _menuItemClass($iLevel, 'lofhk', $bChinese);
	}
	else if ($arLoop[0] == 'sh518800')
	{
	    _menuItemClass($iLevel, 'goldetf', $bChinese);
	}
	else if ($arLoop[0] == 'sh502004')
	{
	    _menuItemClass($iLevel, 'gradedfund', $bChinese);
	}
	else if ($arLoop[0] == 'sina')
	{
	    _menuItemClass($iLevel, 'pairtrading', $bChinese);
	}
    NavDirLoop($arLoop);
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function NavStockSoftware($bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res', $bChinese);
	NavContinueNewLine();
    NavMenuSet(GetMenuArray($bChinese));
	NavContinueNewLine();
    NavSwitchLanguage($bChinese);
    NavEnd();
}

function _LayoutTopLeft($bChinese)
{
    LayoutTopLeft(NavStockSoftware, $bChinese);
}

function NavLoopFuture($bChinese)
{
    ResMenu(FutureGetSymbolArray(), $bChinese);
}

function _LayoutFutureTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopFuture, $bChinese);
}

function NavLoopGradedFund($bChinese)
{
    ResMenu(GradedFundGetSymbolArray(), $bChinese);
}

function _LayoutGradedFundTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopGradedFund, $bChinese);
}

function NavLoopGoldEtf($bChinese)
{
    ResMenu(GoldEtfGetSymbolArray(), $bChinese);
}

function _LayoutGoldEtfTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopGoldEtf, $bChinese);
}

function NavLoopLof($bChinese)
{
    ResMenu(LofGetSymbolArray(), $bChinese);
}

function _LayoutLofTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopLof, $bChinese);
}

function NavLoopLofHk($bChinese)
{
    ResMenu(LofHkGetSymbolArray(), $bChinese);
}

function _LayoutLofHkTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopLofHk, $bChinese);
}

function NavLoopPairTrading($bChinese)
{
    ResMenu(PairTradingGetSymbolArray(), $bChinese);
}

function _LayoutPairTradingTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopPairTrading, $bChinese);
}

function NavLoopAdr($bChinese)
{
    ResMenu(AdrGetSymbolArray(), $bChinese);
}

function _LayoutAdrTopLeft($bChinese)
{
    LayoutTopLeft(NavLoopAdr, $bChinese);
}

?>
