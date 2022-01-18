<?php
require_once('/php/layout.php');
require_once('/php/stocklink.php');
require_once('/woody/php/_navwoody.php');

function NavStockSoftware($bChinese)
{
    $iLevel = 1;
    $ar = GetStockMenuArray();
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'res');
	MenuContinueNewLine();

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
	   		MenuWriteItemLink($iLevel - 1, $strKey, UrlGetPhp(), $ar[$strKey]);
	   		MenuContinueNewLine();
    		MenuDirLoop($arTitle);
    		MenuEnd();
    		return;
    	}
    }
    
    MenuSet($ar);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('NavStockSoftware', false, $bChinese, $bAdsense);
}

?>
