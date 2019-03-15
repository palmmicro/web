<?php
require_once('_stock.php');
require_once('_edittransactionform.php');

function _getOperationStr($bChinese)
{
    if (UrlGetQueryValue('edit'))
    {
    	$str = $bChinese ? STOCK_TRANSACTION_EDIT_CN : STOCK_TRANSACTION_EDIT;
    }
    else
    {
    	$str = $bChinese ? STOCK_TRANSACTION_NEW_CN : STOCK_TRANSACTION_NEW;
    }
    return $str;
}

function EchoAll($bChinese = true)
{
	StockEditTransactionForm();
}

function EchoMetaDescription($bChinese = true)
{
	$str = _getOperationStr($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/woody/res/php/_submittransaction.php和_edittransactionform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This page works together with php/_submittransaction.php and php/_edittransactionform.php to $str.";
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    echo _getOperationStr($bChinese);
}

    AcctAuth();

?>
