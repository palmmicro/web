<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

function _getEditStockOptionSubmit($strPage)
{
    $ar = GetStockOptionArray();
	return $ar[$strPage];
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
      	$strPage = UrlGetPage();
       	$acct->StockOptionEditForm(_getEditStockOptionSubmit($strPage));
    }
}

function GetMetaDescription()
{
	global $acct;
	
	$strPage = UrlGetPage();
    $str = '本中文页面文件跟/woody/res/php/_submitstockoptions.php和_editstockoptionform.php一起配合, 对'.$acct->GetStockDisplay();
    $str .= _getEditStockOptionSubmit($strPage);
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetSymbolDisplay()._getEditStockOptionSubmit(UrlGetPage());
}

    $acct = new SymbolEditAccount();
?>
