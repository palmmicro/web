<?php
require_once('_stock.php');

function EchoAll()
{
	global $acct;
    
	StockEditTransactionForm($acct, STOCK_TRANSACTION_EDIT);
}

function GetMetaDescription()
{
	$strSubmit = STOCK_TRANSACTION_EDIT;
   	$str = "本中文页面文件跟/woody/res/php/_submittransaction.php和_edittransactionform.php一起配合完成{$strSubmit}的功能.";
    return CheckMetaDescription($str);
}

function GetTitle()
{
	return STOCK_TRANSACTION_EDIT;
}

   	$acct = new StockAccount();
	$acct->Auth();
?>
