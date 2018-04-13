<?php

// ****************************** SqlCnyReference class *******************************************************
class SqlCnyReference extends CnyReference
{
    // constructor 
    function SqlCnyReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_SQL_FOREX;
        parent::CnyReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
