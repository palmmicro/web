<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

function _getEditStockOptionSubmit($strTitle)
{
    $ar = GetStockOptionArray();
	return $ar[$strTitle];
}

function EchoAll()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
    	
        $ref = StockGetReference(new StockSymbol($strSymbol));
        if ($ref->HasData())
        {
        	$strTitle = UrlGetTitle();
        	StockOptionEditForm($ref, _getEditStockOptionSubmit($strTitle));
        }
    }
}

function EchoMetaDescription()
{
	$strTitle = UrlGetTitle();
    $str = '本中文页面文件跟/woody/res/php/_submitstockoptions.php和/woody/res/php/_editstockoptionform.php一起配合';
    $str .= _getEditStockOptionSubmit($strTitle);
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    echo _getEditStockOptionSubmit(UrlGetTitle());
}

    AcctAuth();
    
?>
