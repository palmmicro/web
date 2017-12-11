<?php
require_once('_stock.php');
require_once('_editmergeform.php');

    AcctNoAuth();

	if (isset($_POST['submit']))
	{
		if ($_POST['submit'] == STOCK_TRANSACTION_MERGE || $_POST['submit'] == STOCK_TRANSACTION_MERGE_CN)
		{
		    if ($_POST['type0'] == '0')    // From
		    {
		        $strSrcGroupItemId = $_POST['symbol0'];
		        $strDstGroupItemId = $_POST['symbol1'];
		    }
		    else
		    {
		        $strSrcGroupItemId = $_POST['symbol1'];
		        $strDstGroupItemId = $_POST['symbol0'];
		    }
		    
		    if (SqlMergeStockTransaction($strSrcGroupItemId, $strDstGroupItemId))
		    {
		        StockGroupItemTransactionUpdate($strSrcGroupItemId);
		        StockGroupItemTransactionUpdate($strDstGroupItemId);
		    }
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
