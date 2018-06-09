<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
require_once('/php/ui/stockgroupparagraph.php');
require_once('_edittransactionform.php');
require_once('_editmergeform.php');

function _updateStockGroupItemTransaction($strGroupItemId)
{
    $trans = new StockTransaction();
	$sql = new StockTransactionSql();
    if ($result = $sql->Get($strGroupItemId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            AddSqlTransaction($trans, $record);
        }
        @mysql_free_result($result);
    }
    SqlUpdateStockGroupItem($strGroupItemId, strval($trans->iTotalShares), strval($trans->fTotalCost), strval($trans->iTotalRecords));
}

function _updateStockGroupItem($strGroupId, $strGroupItemId)
{
	if ($strGroupId == false)		return;
	if ($strGroupItemId == false)	return;
	
	$sql = new StockGroupItemSql($strGroupId);
	if ($result = $sql->GetAll())
	{
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    _updateStockGroupItemTransaction($stockgroupitem['id']);
		}
		@mysql_free_result($result);
	}
}

function _getStockQuantity()
{
	$strQuantity = UrlCleanString($_POST['quantity']);
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
    $strGroupId = $groupitem['group_id'];
	if (StockGroupIsReadOnly($strGroupId))
	{
		return false;
	}
	return $strGroupId;
}

function _onDelete($strId, $strGroupItemId)
{
    if ($strGroupId = _canModifyStockTransaction($strGroupItemId))
    {
        SqlDeleteTableDataById('stocktransaction', $strId);
    }
    return $strGroupId;
}

function _getGroupOwnerLink($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
	return GetMemberLink($strMemberId);
}

function _getStockTransactionLink($strGroupId, $strStockId)
{
    $strSymbol = SqlGetStockSymbol($strStockId);
    return StockGetTransactionLink($strGroupId, $strSymbol); 
}

function _emailStockTransaction($sql, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
	$groupitem = $sql->GetDataById($strGroupItemId);
//    $groupitem = SqlGetStockGroupItemById($strGroupItemId);
    $strGroupId = $groupitem['group_id'];
    
    $strSubject = 'Stock Transaction: '.$_POST['submit'];
	$str = _getGroupOwnerLink($strGroupId);
    $str .= '<br />Symbol: '._getStockTransactionLink($strGroupId, $groupitem['stock_id']); 
    $str .= '<br />Quantity: '.$strQuantity; 
    $str .= '<br />Price: '.$strPrice; 
    $str .= '<br />Cost: '.$strCost; 
    $str .= '<br />Remark: '.$strRemark; 
    EmailReport($str, $strSubject); 
}

function _emailFundPurchase($strGroupId, $strFundId, $strArbitrageId)
{
    $strSubject = 'Arbitrage Fund Purchase';
	$str = _getGroupOwnerLink($strGroupId);
    $str .= '<br />Fund: '._getStockTransactionLink($strGroupId, $strFundId); 
    $str .= '<br />Arbitrage: '._getStockTransactionLink($strGroupId, $strArbitrageId); 
    EmailReport($str, $strSubject); 
}

function _onArbitrageCost($strQuantity, $strPrice)
{
    $iQuantity = intval($strQuantity);
    $fPrice = floatval($strPrice);
    $fCost = $iQuantity * 0.005 + $iQuantity * $fPrice * 0.000028;
    return strval($fCost);
}

// groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f&arbitrageid=%s&quantity=%s&price=%.2f
function _onAddFundPurchase($strGroupId)
{
	if (StockGroupIsReadOnly($strGroupId))    							return false;
	if (($strFundId = UrlGetQueryValue('fundid')) == false)    			return false;
	if (($strAmount = UrlGetQueryValue('amount')) == false)    			return false;
	if (($strNetValue = UrlGetQueryValue('netvalue')) == false)    		return false;
	if (($strArbitrageId = UrlGetQueryValue('arbitrageid')) == false)	return false;
	if (($strQuantity = UrlGetQueryValue('quantity')) == false)    		return false;
	if (($strPrice = UrlGetQueryValue('price')) == false)    			return false;
	
	$sql = new StockGroupItemSql($strGroupId);
	if (($strGroupItemId = $sql->GetTableId($strFundId)) == false)    return false;
	if ($sql->trans_sql->Insert($strGroupItemId, strval(intval(floatval($strAmount) / floatval($strNetValue))), $strNetValue, '', '{'))
	{
	    if ($strGroupItemId = $sql->GetTableId($strArbitrageId))
	    {
	        $sql->trans_sql->Insert($strGroupItemId, '-'.$strQuantity, $strPrice, _onArbitrageCost($strQuantity, $strPrice), '}');
	    }
	    _emailFundPurchase($strGroupId, $strFundId, $strArbitrageId);
	}
    return $strGroupItemId;
}

function _onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
    if ($strGroupId = _canModifyStockTransaction($strGroupItemId))
    {
    	$sql = new StockGroupItemSql($strGroupId);
        if ($sql->trans_sql->Update($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
        {
            _emailStockTransaction($sql, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
        }
    }
    return $strGroupId;
}

function _onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
{
    if ($strGroupId = _canModifyStockTransaction($strGroupItemId))
    {
    	$sql = new StockGroupItemSql($strGroupId);
    	if ($sql->trans_sql->Insert($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
    	{
    		_emailStockTransaction($sql, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
    	}
    }
    return $strGroupId;
}

function _onMergeTransaction()
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
		    
//    if (SqlMergeStockTransaction($strSrcGroupItemId, $strDstGroupItemId))
	$sql = new StockTransactionSql();
	if ($sql->Merge($strSrcGroupItemId, $strDstGroupItemId))
    {
        _updateStockGroupItemTransaction($strSrcGroupItemId);
        _updateStockGroupItemTransaction($strDstGroupItemId);
    }
}

    AcctNoAuth();
    $strGroupId = false;
    $strGroupItemId = false;
	if (isset($_POST['submit']))
	{
		if ($_POST['submit'] == STOCK_TRANSACTION_MERGE || $_POST['submit'] == STOCK_TRANSACTION_MERGE_CN)
		{
			_onMergeTransaction();
			unset($_POST['submit']);
			SwitchToSess();		
		}
		
	    $strGroupItemId = $_POST['symbol'];
	    $strQuantity = _getStockQuantity();
		$strPrice = UrlCleanString($_POST['price']);
	    $strCost = _getStockCost();
		$strRemark = UrlCleanString($_POST['remark']);
		if ($_POST['submit'] == STOCK_TRANSACTION_NEW || $_POST['submit'] == STOCK_TRANSACTION_NEW_CN)
		{	// post new transaction
		    $strGroupId = _onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
		}
		else if ($_POST['submit'] == STOCK_TRANSACTION_EDIT || $_POST['submit'] == STOCK_TRANSACTION_EDIT_CN)
		{	// edit transaction
		    if ($strId = UrlGetQueryValue('edit'))
		    {
		        $strGroupId = _onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
		    }
		}
		unset($_POST['submit']);
	}
	else if ($strId = UrlGetQueryValue('delete'))
	{
	    $transaction = SqlGetStockTransactionById($strId);
	    $strGroupItemId = $transaction['groupitem_id'];
	    $strGroupId = _onDelete($strId, $strGroupItemId);
	}
	else if ($strGroupId = UrlGetQueryValue('groupid'))
	{
	    $strGroupItemId = _onAddFundPurchase($strGroupId);
	}

	_updateStockGroupItem($strGroupId, $strGroupItemId);
	SwitchToSess();
?>
