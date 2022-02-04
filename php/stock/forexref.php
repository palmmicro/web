<?php

// ****************************** ForexReference class *******************************************************
class ForexReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    function ForexReference($strSymbol)
    {
        parent::MysqlReference($strSymbol);
    }
    
    public function LoadData()
    {
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            $this->LoadSinaForexData();
            $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
        }
    }
}

?>
