<?php
require_once('_stock.php');

// ****************************** Private functions *******************************************************

function _echoAllFundTables($arFundRef, $bChinese)
{
    EchoFundReferenceTable($arFundRef, $bChinese);
    EchoNewLine();
    EchoFundEstimationTable($arFundRef, $bChinese);
}

function _echoNewLinkReferenceTable($arSymbol, $fNewLinkCallback, $bChinese)
{
    PrefetchStockData($arSymbol);
    
    $arRef = array();
    foreach ($arSymbol as $strSymbol)
    {
        $ref = new MyStockReference($strSymbol);
        $ref->strExternalLink = call_user_func($fNewLinkCallback, $strSymbol, $bChinese);
        $arRef[] = $ref;
    }
    EchoReferenceTable($arRef, $bChinese);
}
        
function _echoCommonToolTable($ar, $bChinese)
{
    _echoNewLinkReferenceTable(StockGetArraySymbol($ar), GetCommonToolLink, $bChinese);
}

// ****************************** Graded Fund tool table *******************************************************

function EchoGradedFundToolTable($bChinese)
{
    _echoCommonToolTable(GradedFundGetSymbolArray(), $bChinese);
}

// ****************************** Pair traing tool table *******************************************************

function EchoPairTradingToolTable($bChinese)
{
    _echoCommonToolTable(PairTradingGetSymbolArray(), $bChinese);
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

// ****************************** HK LOF tool table *******************************************************

function _echoLofHkToolTable($arFundSymbol, $bChinese)
{
    $arSymbol = StockGetArraySymbol($arFundSymbol);
    
    $arAll = array();
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, LofHkGetAllSymbolArray($strSymbol));
    }
    PrefetchStockData(array_unique($arAll));
    
    $arFundRef = array();
    foreach ($arSymbol as $strSymbol)
    {
        $arFundRef[] = new MyLofHkReference($strSymbol);
    }
    _echoAllFundTables($arFundRef, $bChinese);
}

function EchoHSharesToolTable($bChinese)
{
    _echoLofHkToolTable(LofHkGetHSharesSymbolArray(), $bChinese);
}

function EchoHangSengToolTable($bChinese)
{
    _echoLofHkToolTable(LofHkGetHangSengSymbolArray(), $bChinese);
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

// ****************************** ADR tool table *******************************************************

function EchoAdrToolTable($bChinese)
{
    $ar = AdrGetSymbolArray();
    $arSymbol = array();
    foreach ($ar as $str)
    {
        $arSymbol[] = StockGetSymbolByTitle($str);
    }
    _echoNewLinkReferenceTable($arSymbol, GetAdrToolLink, $bChinese);
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
