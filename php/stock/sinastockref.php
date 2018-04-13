<?php

// ****************************** SinaStockReference class *******************************************************
class SinaStockReference extends MyStockReference
{
    // constructor 
    function SinaStockReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_SINA_DATA;
        parent::MyStockReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
