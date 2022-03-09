<?php
require_once('/php/layout.php');
require_once('/php/visitorlogin.php');
require_once('/php/stocklink.php');
require_once('/woody/php/_woodymenu.php');

function _menuStockSoftware($bChinese)
{
    $iLevel = 1;
    $ar = GetStockMenuArray();
    
	MenuBegin();
	WoodyMenuItem($iLevel, 'res');
	MenuContinueNewLine();

	$strPage = UrlGetPage();
    $arFunction = array('adr' => 'AdrGetSymbolArray',
                      	   'chinaindex' => 'ChinaIndexGetSymbolArray',
                      	   'goldsilver' => 'GoldSilverGetSymbolArray',
                      	   'qdii' => 'QdiiGetSymbolArray',
                      	   'qdiimix' => 'QdiiMixGetSymbolArray',
                      	   'qdiihk' => 'QdiiHkGetSymbolArray');
    
    foreach ($arFunction as $strKey => $strFunction)
    {
    	$arTitle = array();
    	$arSymbol = call_user_func($strFunction);
    	foreach ($arSymbol as $strSymbol)	$arTitle[] = strtolower($strSymbol);
    	
    	if (in_array($strPage, $arTitle))
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
    LayoutTopLeft('_menuStockSoftware', false, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true)
{
    VisitorLogin($bChinese);
    LayoutTail($bChinese, true);
}

?>
