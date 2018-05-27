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
    if ($result = SqlGetStockTransactionByGroupItemId($strGroupItemId, 0, 0)) 
    {
        while ($transaction = mysql_fetch_assoc($result)) 
        {
            AddSqlTransaction($trans, $transaction);
        }
        @mysql_free_result($result);
    }
    SqlUpdateStockGroupItem($strGroupItemId, strval($trans->iTotalShares), strval($trans->fTotalCost), strval($trans->iTotalRecords));
}

function _updateStockGroupItem($strGroupItemId)
{
    $groupitem = SqlGetStockGroupItemById($strGroupItemId);
	if ($result = SqlGetStockGroupItemByGroupId($groupitem['group_id']))
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
	if (StockGroupIsReadOnly($groupitem['group_id']))    return false;
	
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
	$str = GetMemberLink($strMemberId, $bChinese);
    $str .= '<br />Symbol: '.StockGetSingleTransactionLink($strGroupId, $strSymbol, $bChinese); 
    $str .= '<br />Quantity: '.$strQuantity; 
    $str .= '<br />Price: '.$strPrice; 
    $str .= '<br />Cost: '.$strCost; 
    $str .= '<br />Remark: '.$strRemark; 
    EmailReport($str, $strSubject); 
}

function _emailFundPurchase($strGroupId, $strFundId, $strArbitrageId)
{
    $bChinese = true;
    $strSubject = 'Arbitrage Fund Purchase';
	$strMemberId = SqlGetStockGroupMemberId($strGroupId);
	$str = GetMemberLink($strMemberId, $bChinese);
    $str .= '<br />Fund: '.StockGetSingleTransactionLink($strGroupId, SqlGetStockSymbol($strFundId), $bChinese); 
    $str .= '<br />Arbitrage: '.StockGetSingleTransactionLink($strGroupId, SqlGetStockSymbol($strArbitrageId), $bChinese); 
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
	
	if (($strGroupItemId = SqlGetStockGroupItemId($strGroupId, $strFundId)) == false)    return false;
	if (SqlInsertStockTransaction($strGroupItemId, strval(intval(floatval($strAmount) / floatval($strNetValue))), $strNetValue, '', '{'))
	{
	    if ($strGroupItemId = SqlGetStockGroupItemId($strGroupId, $strArbitrageId))
	    {
	        SqlInsertStockTransaction($strGroupItemId, '-'.$strQuantity, $strPrice, _onArbitrageCost($strQuantity, $strPrice), '}');
	    }
	    _emailFundPurchase($strGroupId, $strFundId, $strArbitrageId);
	}
    return $strGroupItemId;
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
		    
    if (SqlMergeStockTransaction($strSrcGroupItemId, $strDstGroupItemId))
    {
        _updateStockGroupItemTransaction($strSrcGroupItemId);
        _updateStockGroupItemTransaction($strDstGroupItemId);
    }
}

    AcctNoAuth();
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
	else if ($strId = UrlGetQueryValue('delete'))
	{
	    $transaction = SqlGetStockTransactionById($strId);
	    $strGroupItemId = $transaction['groupitem_id'];
	    _onDelete($strId, $strGroupItemId);
	}
	else if ($strGroupId = UrlGetQueryValue('groupid'))
	{
	    $strGroupItemId = _onAddFundPurchase($strGroupId);
	}

	if ($strGroupItemId)		_updateStockGroupItem($strGroupItemId);
	SwitchToSess();
?>
