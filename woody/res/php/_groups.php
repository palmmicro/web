<?php
require_once('_stock.php');

// ****************************** Private functions *******************************************************

function _echoAllFundTables($arFundRef, $bChinese)
{
    EchoFundReferenceTable($arFundRef, $bChinese);
    EchoNewLine();
    EchoFundEstimationTable($arFundRef, $bChinese);
}

      
// ****************************** LOF tool table *******************************************************

function _echoLofToolTable($arFundSymbol, $bChinese)
{
    $arAll = array();
    $arSymbol = StockGetArraySymbol($arFundSymbol);
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, LofGetAllSymbolArray($strSymbol));
    }
    PrefetchStockData(array_unique($arAll));
    
    $arFundRef = array();
    foreach ($arSymbol as $strSymbol)
    {
        $arFundRef[] = new MyLofReference($strSymbol);
    }
    _echoAllFundTables($arFundRef, $bChinese);
}

function EchoSpyFundToolTable($bChinese)
{
    _echoLofToolTable(LofGetSpySymbolArray(), $bChinese);
}

function EchoOilFundToolTable($bChinese)
{
    _echoLofToolTable(array_merge(LofGetOilSymbolArray(), LofGetOilEtfSymbolArray()), $bChinese);
}

// ****************************** Gold ETF tool table *******************************************************

function EchoGoldEtfToolTable($bChinese)
{
    $arSymbol = StockGetArraySymbol(GoldEtfGetSymbolArray());
    $arLofSymbol = StockGetArraySymbol(LofGetGoldSymbolArray());
    
    $arAll = array();
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, GoldEtfGetAllSymbolArray($strSymbol));
    }
    foreach ($arLofSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, LofGetAllSymbolArray($strSymbol));
    }
    PrefetchStockData(array_unique($arAll));
    
    $arFundRef = array();
    foreach ($arSymbol as $strSymbol)
    {
        $arFundRef[] = new MyGoldEtfReference($strSymbol);
    }
    foreach ($arLofSymbol as $strSymbol)
    {
        $arFundRef[] = new MyLofReference($strSymbol);
    }
    _echoAllFundTables($arFundRef, $bChinese);
}

// ****************************** Future ETF tool table *******************************************************

function EchoFutureToolTable($bChinese)
{
    $ar = FutureGetSymbolArray();
    $arSymbol = array();
    $arPrefetch = array();
    foreach ($ar as $str)
    {
        $strSymbol = StockGetSymbolByTitle($str);
        $arSymbol[] = $strSymbol;
        $arPrefetch[] = FutureGetSinaSymbol($strSymbol);
    }
    PrefetchStockData($arPrefetch);
    
    $arRef = array();
    foreach ($arSymbol as $strSymbol)
    {
        $ref = new MyFutureReference($strSymbol);
        $ref->strExternalLink = GetFutureToolLink($strSymbol, $bChinese);
        $arRef[] = $ref;
    }
    EchoReferenceTable($arRef, $bChinese);
}

    AcctNoAuth();

?>
