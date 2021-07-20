<?php
require_once('/php/layout.php');
require_once('/php/stocklink.php');
require_once('/woody/php/_navwoody.php');

function NavStockSoftware($bChinese)
{
    $iLevel = 1;
    $ar = GetStockMenuArray();
    
	NavBegin();
	WoodyMenuItem($iLevel, 'res');
	NavContinueNewLine();

	$strTitle = UrlGetTitle();
    $arFunction = array(ADR_PAGE => 'AdrGetSymbolArray',
                      	   CHINA_INDEX_PAGE => 'ChinaIndexGetSymbolArray',
                      'goldetf' => 'GoldSilverGetSymbolArray',
                      'lof' => 'QdiiGetSymbolArray',
                      'lofhk' => 'QdiiHkGetSymbolArray',
                     );
    foreach ($arFunction as $strKey => $strFunction)
    {
    	$arSymbol = call_user_func($strFunction);
    	if (in_array($strTitle, $arSymbol))
    	{
	   		NavWriteItemLink($iLevel - 1, $strKey, UrlGetPhp(), $ar[$strKey]);
	   		NavContinueNewLine();
    		NavDirLoop($arSymbol);
    		NavEnd();
    		return;
    	}
    }
    
    NavMenuSet($ar);
    NavEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavStockSoftware', false, $bChinese, $bAdsense);
}

?>
