<?php
require_once('/php/layout.php');
require_once('/woody/php/_navwoody.php');

function GetMenuArray()
{
    return array('adr' => 'ADR工具',
                      'chinaetf' => 'A股ETF',
                      'goldetf' => '黄金ETF',
                      'lof' => 'LOF工具',
                      'lofhk' => '香港LOF',
                     );
}

function _menuItemClass($iLevel, $strClass)
{
    $iLevel --;
    $ar = GetMenuArray();
    $strDisp = $ar[$strClass];
   	NavWriteItemLink($iLevel, $strClass, UrlGetPhp(), $strDisp);
    NavContinueNewLine();
}

function NavStockSoftware($bChinese)
{
    $iLevel = 1;
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res');
	NavContinueNewLine();

	$strTitle = UrlGetTitle();
    $arFunction = array('adr' => 'AdrGetSymbolArray',
                      'chinaetf' => 'ChinaEtfGetSymbolArray',
                      'goldetf' => 'GoldEtfGetSymbolArray',
                      'lof' => 'LofGetSymbolArray',
                      'lofhk' => 'LofHkGetSymbolArray',
                     );
    foreach ($arFunction as $strKey => $strFunction)
    {
    	$arSymbol = call_user_func($strFunction);
    	if (in_array($strTitle, $arSymbol))
    	{
    		_menuItemClass($iLevel, $strKey);
    		NavDirLoop($arSymbol);
    		NavEnd();
    		return;
    	}
    }
    
    NavMenuSet(GetMenuArray());
    NavEnd();
}

function _LayoutTopLeft()
{
    LayoutTopLeft('NavStockSoftware');
}

?>
