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
                      	   GOLD_SILVER_PAGE => 'GoldSilverGetSymbolArray',
                      	   QDII_PAGE => 'QdiiGetSymbolArray',
                      	   QDII_MIX_PAGE => 'QdiiMixGetSymbolArray',
                      	   QDII_HK_PAGE => 'QdiiHkGetSymbolArray');
    
    foreach ($arFunction as $strKey => $strFunction)
    {
    	$arTitle = array();
    	$arSymbol = call_user_func($strFunction);
    	foreach ($arSymbol as $strSymbol)	$arTitle[] = strtolower($strSymbol);
    	
    	if (in_array($strTitle, $arTitle))
    	{
	   		NavWriteItemLink($iLevel - 1, $strKey, UrlGetPhp(), $ar[$strKey]);
	   		NavContinueNewLine();
    		NavDirLoop($arTitle);
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
