<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    function MyStockReference($strSymbol) 
    {
		$sym = new StockSymbol($strSymbol);
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
           	$this->LoadSinaData($sym);
   	        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
        }
        else if (self::$strDataSource == STOCK_YAHOO_DATA)
        {
            $this->LoadYahooData($sym);
        }
        else if (self::$strDataSource == STOCK_GOOGLE_DATA)
        {
			$this->LoadGoogleData($sym);
        }
        
        parent::MysqlReference($sym);
    }
}

?>
