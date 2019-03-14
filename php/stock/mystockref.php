<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    function MyStockReference($strSymbol, $sym = false) 
    {
    	if ($sym == false)
    	{
    		$sym = new StockSymbol($strSymbol);
    	}
    	
        switch (self::$strDataSource)
        {
        case STOCK_SINA_DATA:
           	$this->LoadSinaData($sym);
   	        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
   	        break;

   	    case STOCK_YAHOO_DATA:
            $this->LoadYahooData($sym);
            break;

        case STOCK_GOOGLE_DATA:
			$this->LoadGoogleData($sym);
			break;
        }
        
        parent::MysqlReference($sym);
    }
}

?>
