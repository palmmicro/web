<?php
require_once('_stock.php');
require_once('_edittransactionform.php');

function EchoAll()
{
	StockEditTransactionForm(STOCK_TRANSACTION_EDIT);
}

function EchoMetaDescription()
{
	$strSubmit = STOCK_TRANSACTION_EDIT;
   	$str = "本中文页面文件跟/woody/res/php/_submittransaction.php和_edittransactionform.php一起配合完成{$strSubmit}的功能.";
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
    echo STOCK_TRANSACTION_EDIT;
}

   	$acct = new Account();
	$acct->Auth();
?>
