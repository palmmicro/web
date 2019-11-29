<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    function MyStockReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);
    }
    
    function LoadData()
    {
        switch (self::$strDataSource)
        {
        case STOCK_SINA_DATA:
           	$this->LoadSinaData();
   	        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
   	        break;

   	    case STOCK_YAHOO_DATA:
            $this->LoadYahooData();
            break;
        }
    }
}

?>
