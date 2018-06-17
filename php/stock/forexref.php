<?php

// ****************************** ForexReference class *******************************************************
class ForexReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;
//    public static $strDataSource = STOCK_EASTMONEY_DATA;

    function ForexReference($strSymbol)
    {
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            $this->LoadSinaForexData($strSymbol);
            $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
        }
        else // if (self::$strDataSource == STOCK_EASTMONEY_DATA)
        {
            $this->LoadEastMoneyForexData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
    }       
}

?>
