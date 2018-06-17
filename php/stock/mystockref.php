<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    function MyStockReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            if ($strSinaSymbol = $this->sym->GetSinaSymbol())
            {
            	$this->LoadSinaData($strSinaSymbol);
       	        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
       	    }
        }
        else if (self::$strDataSource == STOCK_YAHOO_DATA)
        {
            $this->LoadYahooData();
        }
        else if (self::$strDataSource == STOCK_GOOGLE_DATA)
        {
			if ($strGoogleSymbol = $this->sym->GetGoogleSymbol())	$this->LoadGoogleData($strGoogleSymbol);
        }
        
        parent::MysqlReference($strSymbol);
    }
}

?>
