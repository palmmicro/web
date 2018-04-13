<?php

// ****************************** YahooStockReference class *******************************************************
class YahooStockReference extends MyStockReference
{
    // constructor 
    function YahooStockReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_YAHOO_DATA;
        parent::MyStockReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
