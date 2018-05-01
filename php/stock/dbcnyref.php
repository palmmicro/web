<?php

// ****************************** DbCnyReference class *******************************************************
class DbCnyReference extends CnyReference
{
    // constructor 
    function DbCnyReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_DB_FOREX;
        parent::CnyReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
