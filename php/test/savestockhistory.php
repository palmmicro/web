<?php
require_once('/php/debug.php');

require_once('/php/mysqlstock.php');
require_once('/php/mysqllof.php');
require_once('/php/mysqlgold.php');
require_once('/php/mysqlgraded.php');
//require_once('/php/stock.php');
//require_once('/php/sql/sqlstock.php');

define ('MAX_STOCK_HISTORY', 900);

function _debugStockHistory($strSymbol)
{
    $strStockId = SqlGetStockId($strSymbol);
    if ($result = SqlGetStockHistory($strStockId, 0, MAX_STOCK_HISTORY)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            DebugString($history['date'].' '.$history['open'].' '.$history['high'].' '.$history['low'].' '.$history['close'].' '.$history['volume'].' '.$history['adjclose']);
        }
        @mysql_free_result($result);
    }
}

function _saveFundHistory()
{
    $arAll = array();
    
    $arSymbol = StockGetArraySymbol(LofGetSymbolArray());
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, LofGetAllSymbolArray($strSymbol));
    }
    
    $arSymbol = StockGetArraySymbol(LofHkGetSymbolArray());
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, LofHkGetAllSymbolArray($strSymbol));
    }
    
    $arSymbol = StockGetArraySymbol(GoldEtfGetSymbolArray());
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, GoldEtfGetAllSymbolArray($strSymbol));
    }

    $arSymbol = StockGetArraySymbol(GradedFundGetSymbolArray());
    foreach ($arSymbol as $strSymbol)
    {
        $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbol));
    }

    $ar = array_unique($arAll);
    foreach ($ar as $strSymbol)
    {
        DebugString('_saveFundHistory: '.$strSymbol);
        $strStockId = SqlGetStockId($strSymbol);
        StockUpdateYahooHistory($strStockId, $strSymbol);
    }
}

function SaveStockHistory()
{
    $strSymbol = 'PTR';
    $strStockId = SqlGetStockId($strSymbol);
    StockUpdateYahooHistory($strStockId, $strSymbol);
    _debugStockHistory($strSymbol);
    
//    _saveFundHistory();
}

?>
