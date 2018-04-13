<?php

// ****************************** FutureReference class *******************************************************
class FutureReference extends MyStockReference
{
    // constructor 
    function FutureReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_SINA_FUTURE_DATA;
        parent::MyStockReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
