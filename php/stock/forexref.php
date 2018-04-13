<?php

// ****************************** ForexReference class *******************************************************
class ForexReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_FOREX;
//    public static $strDataSource = STOCK_EASTMONEY_FOREX;

    // constructor 
    function ForexReference($strSymbol)
    {
        if (self::$strDataSource == STOCK_SINA_FOREX)
        {
            $this->LoadSinaForexData($strSymbol);
        }
        else // if (self::$strDataSource == STOCK_EASTMONEY_FOREX)
        {
            $this->LoadEastMoneyForexData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
    }       
}

?>
