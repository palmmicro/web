<?php
require_once('_stock.php');
require_once('_editstockform.php');

function _onDelete($strSymbol)
{
}

function _onEdit($strStockId, $strSymbol, $strDescription, $bChinese)
{
    $stock = SqlGetTableDataById('stock', $strStockId);
    $strSymbol = $stock['name'];
    if ($bChinese)
    {
        SqlUpdateStock($strStockId, $strSymbol, $stock['us'], $strDescription);
    }
    else
    {
        SqlUpdateStock($strStockId, $strSymbol, $strDescription, $stock['cn']);
    }
    EmailDebug($strSymbol.' '.$strDescription, 'Edit Stock');
}

function _onNew($strSymbol, $strDescription, $bChinese)
{
    EmailDebug($strSymbol.' '.$strDescription, 'New Stock');
}

    AcctAuth();

	if ($strSymbol = UrlGetQueryValue('delete'))
	{
	    _onDelete($strSymbol);
	}
	else if (isset($_POST['submit']))
	{
		$strPostSymbol = FormatCleanString($_POST['symbol']);
		$strDescription = FormatCleanString($_POST['description']);

		$bChinese = (UrlGetQueryValue('cn') == '1') ? true : false;
		$strSymbol = UrlGetQueryValue('edit');
		if ($_POST['submit'] == STOCK_EDIT || $_POST['submit'] == STOCK_EDIT_CN)
		{	// edit stock
		    _onEdit(SqlGetStockId($strSymbol), $strPostSymbol, $strDescription, $bChinese);
		}
		else if ($_POST['submit'] == STOCK_NEW || $_POST['submit'] == STOCK_NEW_CN)
		{
		    _onNew($strPostSymbol, $strDescription, $bChinese);
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
