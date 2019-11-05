<?php
require_once('/php/layout.php');
require_once('/php/stocklink.php');
require_once('/woody/php/_navwoody.php');

function _menuItemClass($iLevel, $strClass)
{
    $iLevel --;
    $ar = GetStockMenuArray();
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
    $arFunction = array(ADR_PAGE => 'AdrGetSymbolArray',
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
    
    NavMenuSet(GetStockMenuArray());
    NavEnd();
}

function _LayoutTopLeft()
{
    LayoutTopLeft('NavStockSoftware');
}

?>
