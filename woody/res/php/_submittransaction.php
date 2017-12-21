<?php
require_once('/php/account.php');
require_once('/php/stocklink.php');
require_once('_stock.php');
require_once('_edittransactionform.php');

function _getStockQuantity()
{
	$strQuantity = FormatCleanString($_POST['quantity']);
	if ($_POST['type'] == '0')    // sell
	{
	    $strQuantity = '-'.$strQuantity;
	}
	return $strQuantity; 
}

function _getStockCost()
{
	if ($_POST['commissiontype'] == '0')    // amount
	{
	    $fCommission = floatval($_POST['commission']);
	}
	else
	{
	    $fCommission = floatval($_POST['quantity']) * floatval($_POST['price']) * floatval($_POST['commission']) / 1000.0;
	}

	if ($_POST['taxtype'] == '0')    // amount
	{
	    $fTax = floatval($_POST['tax']);
	}
	else // if ($_POST['taxtype'] == '1')    // percentage
	{
	    $fTax = floatval($_POST['quantity']) * floatval($_POST['price']) * floatval($_POST['tax']) / 1000.0;
	}
	
	return strval(round($fCommission + $fTax, 3));
}

function _canModifyStockTransaction($strGroupItemId)
{
    $groupitem = SqlGetStockGroupItemById($strGroupItemId);
	if (IsStockGroupReadOnly($groupitem['group_id']))    return false;
	
	return true;
}

function _onDelete($strId, $strGroupItemId)
{
    if (_canModifyStockTransaction($strGroupItemId))
    {
        SqlDeleteTableDataById('stocktransaction', $strId);
    }
}

function _emailStockTransaction($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
    $strOperation = $_POST['submit'];
    $groupitem = SqlGetStockGroupItemById($strGroupItemId);
    $strGroupId = $groupitem['group_id'];
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
    $strSymbol = SqlGetStockSymbol($groupitem['stock_id']);
    
    $bChinese = true;
    $strSubject = 'Stock Transaction: '.$strOperation;
	$str = AcctGetMemberLink($strMemberId, $bChinese);
    $str .= '<br />Symbol: '.StockGetSingleTransactionLink($strGroupId, $strSymbol, $bChinese); 
    $str .= '<br />Quantity: '.$strQuantity; 
    $str .= '<br />Price: '.$strPrice; 
    $str .= '<br />Cost: '.$strCost; 
    $str .= '<br />Remark: '.$strRemark; 
    EmailDebug($str, $strSubject); 
}

function _onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
    if (_canModifyStockTransaction($strGroupItemId))
    {
        if (SqlEditStockTransaction($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
        {
            _emailStockTransaction($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
        }
    }
}

function _onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
    if (SqlInsertStockTransaction($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
    {
        _emailStockTransaction($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
    }
}

    AcctNoAuth();

	if ($strId = UrlGetQueryValue('delete'))
	{
	    $transaction = SqlGetStockTransactionById($strId);
	    $strGroupItemId = $transaction['groupitem_id'];
	    _onDelete($strId, $strGroupItemId);
	}
	else if (isset($_POST['submit']))
	{
	    $strGroupItemId = $_POST['symbol'];
	    $strQuantity = _getStockQuantity();
		$strPrice = FormatCleanString($_POST['price']);
	    $strCost = _getStockCost();
		$strRemark = FormatCleanString($_POST['remark']);

		if ($_POST['submit'] == STOCK_TRANSACTION_NEW || $_POST['submit'] == STOCK_TRANSACTION_NEW_CN)
		{	// post new transaction
		    _onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
		}
		else if ($_POST['submit'] == STOCK_TRANSACTION_EDIT || $_POST['submit'] == STOCK_TRANSACTION_EDIT_CN)
		{	// edit transaction
		    if ($strId = UrlGetQueryValue('edit'))
		    {
		        _onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
		    }
		}
		unset($_POST['submit']);
	}

	StockGroupItemUpdate($strGroupItemId);
	SwitchToSess();
?>
