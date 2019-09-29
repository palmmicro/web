<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_editstockoptionform.php');

function _getEditStockOptionSubmit($strTitle)
{
    $ar = GetStockOptionArray();
	return $ar[$strTitle];
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
      	$strTitle = UrlGetTitle();
       	StockOptionEditForm($ref, _getEditStockOptionSubmit($strTitle));
    }
}

function EchoMetaDescription()
{
	global $acct;
	
	$strTitle = UrlGetTitle();
    $str = '本中文页面文件跟/woody/res/php/_submitstockoptions.php和_editstockoptionform.php一起配合, 对'.$acct->GetStockDisplay();
    $str .= _getEditStockOptionSubmit($strTitle);
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay()._getEditStockOptionSubmit(UrlGetTitle());
    echo $str;
}

    $acct = new SymbolAcctStart();
    
?>
