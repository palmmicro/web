<?php
require_once('_stock.php');
require_once('_editmergeform.php');

function _getStockQuantity()
{
	$strQuantity = SqlCleanString($_POST['quantity']);
	if ($_POST['type'] == '0')    // sell
	{
	    $strQuantity = '-'.$strQuantity;
	}
	return $strQuantity; 
}

function _getStockCost()
{
	if ($_POST['commissionselect'] == '0')    // amount
	{
	    $fCommission = floatval($_POST['commission']);
	}
	else
	{
	    $fCommission = floatval($_POST['quantity']) * floatval($_POST['price']) * floatval($_POST['commission']) / 1000.0;
	}

	if (isset($_POST['taxselect']))
	{
		if ($_POST['taxselect'] == '0')    // amount
		{
			$fTax = floatval($_POST['tax']);
		}
		else // if ($_POST['taxselect'] == '1')    // percentage
		{
			$fTax = floatval($_POST['quantity']) * floatval($_POST['price']) * floatval($_POST['tax']) / 1000.0;
		}
	}
	else
	{
		$fTax = 0.0;
	}
	
	return strval_round($fCommission + $fTax, 3);
}

function _getStockTransactionLink($strGroupId, $strStockId)
{
    $strSymbol = SqlGetStockSymbol($strStockId);
    return StockGetTransactionLink($strGroupId, $strSymbol); 
}

function _debugStockTransaction($strStockId, $strGroupId, $strQuantity, $strPrice, $strCost, $strRemark)
{
	if (strlen($strRemark) == 0)	return;
	
	$str = $_POST['submit'];
    $str .= '<br />Symbol: '._getStockTransactionLink($strGroupId, $strStockId); 
    $str .= '<br />Quantity: '.$strQuantity; 
    $str .= '<br />Price: '.$strPrice; 
    $str .= '<br />Cost: '.$strCost; 
    $str .= '<br />Remark: '.$strRemark; 
    trigger_error($str); 
}

function _debugFundPurchase($strGroupId, $strFundId)
{
	$str = 'Arbitrage Fund Purchase';
    $str .= '<br />Fund: '._getStockTransactionLink($strGroupId, $strFundId); 
    trigger_error($str); 
}

class _SubmitTransactionAccount extends StockAccount
{
    function _canModifyStockTransaction($strGroupItemId)
    {
    	$strGroupId = SqlGetStockGroupId($strGroupItemId);
    	if ($this->IsGroupReadOnly($strGroupId))
    	{
    		return false;
    	}
    	return $strGroupId;
    }

    // groupid=%s&fundid=%s&amount=%.2f&netvalue=%.3f
    function _onAddFundPurchase($strGroupId)
    {
    	if ($this->IsGroupReadOnly($strGroupId))    						return false;
    	if (($strFundId = UrlGetQueryValue('fundid')) == false)    			return false;
    	if (($strAmount = UrlGetQueryValue('amount')) == false)    			return false;
    	if (($strNetValue = UrlGetQueryValue('netvalue')) == false)    		return false;
	
    	$sql = new StockGroupItemSql($strGroupId);
    	if (($strGroupItemId = $sql->GetId($strFundId)) == false)    return false;
    	
    	$strSymbol = SqlGetStockSymbol($strFundId);
    	switch ($strSymbol)
    	{
    	case 'SZ160416':
    		$fFeeRatio = 0.0;
    		break;
    		
    	case 'SZ164906':
    		$fFeeRatio = 0.012;
    		break;
    		
    	default:
    		$fFeeRatio = 0.015;
    		break;
    	}
  	
    	$fAmount = floatval($strAmount);
    	$fQuantity = $fAmount / floatval($strNetValue);
    	$strRemark = '}'.STOCK_DISP_ORDER;
    	if ($strSymbol == 'SZ164906')		$strRemark .= ' '.GetArbitrageQuantity($fQuantity);
    	if ($sql->trans_sql->Insert($strGroupItemId, strval(intval($fQuantity)), $strNetValue, strval_round($fAmount * $fFeeRatio * 0.1), $strRemark))
    	{
	       	_debugFundPurchase($strGroupId, $strFundId);
	    }
	    return $strGroupItemId;
	}
	
    function _onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
    {
    	if ($strGroupId = $this->_canModifyStockTransaction($strGroupItemId))
    	{
    		$sql = new StockGroupItemSql($strGroupId);
    		if ($sql->trans_sql->Insert($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
    		{
    			_debugStockTransaction($sql->GetStockId($strGroupItemId), $strGroupId, $strQuantity, $strPrice, $strCost, $strRemark);
    		}
    	}
    	return $strGroupId;
    }

    function _onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark)
    {
    	if ($strGroupId = $this->_canModifyStockTransaction($strGroupItemId))
    	{
    		$sql = new StockGroupItemSql($strGroupId);
    		if ($sql->trans_sql->Update($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark))
    		{
    			_debugStockTransaction($sql->GetStockId($strGroupItemId), $strGroupId, $strQuantity, $strPrice, $strCost, $strRemark);
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

    	if ($strSrcGroupId = $this->_canModifyStockTransaction($strSrcGroupItemId))
    	{
    		if ($strDstGroupId = $this->_canModifyStockTransaction($strDstGroupItemId))
    		{
    			$sql = new StockGroupItemSql($strSrcGroupId);
    			if ($sql->trans_sql->Merge($strSrcGroupItemId, $strDstGroupItemId))
    			{
    				UpdateStockGroupItemTransaction($sql, $strSrcGroupItemId);
    				UpdateStockGroupItemTransaction(new StockGroupItemSql($strDstGroupId), $strDstGroupItemId);
    			}
    		}
    	}
    }
    
    public function Process($strLoginId)
    {
    	$strGroupId = false;
    	$strGroupItemId = false;
    	if (isset($_POST['submit']))
    	{
    		$strSubmit = $_POST['submit'];
    		if ($strSubmit == STOCK_TRANSACTION_MERGE || $strSubmit == STOCK_TRANSACTION_MERGE_CN)
    		{
    			$this->_onMergeTransaction();
    			unset($_POST['submit']);
    			return;
    		}
		
    		$strGroupItemId = $_POST['symbol'];
    		$strQuantity = _getStockQuantity();
    		$strPrice = SqlCleanString($_POST['price']);
    		$strCost = _getStockCost();
    		$strRemark = SqlCleanString($_POST['remark']);
    		switch ($strSubmit)
    		{
    		case STOCK_TRANSACTION_NEW:
    			$strGroupId = $this->_onNew($strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
    			break;
		    
    		case STOCK_TRANSACTION_EDIT:
    			if ($strId = UrlGetQueryValue('edit'))
    			{
    				$strGroupId = $this->_onEdit($strId, $strGroupItemId, $strQuantity, $strPrice, $strCost, $strRemark);
    			}
    			break;
    		}
    		unset($_POST['submit']);
    	}
    	else if ($strId = UrlGetQueryValue('delete'))
    	{
    		$trans_sql = new StockTransactionSql();
    		if ($record = $trans_sql->GetRecordById($strId))
    		{
    			$strGroupItemId = $record['groupitem_id'];
   				$strGroupId = $this->IsAdmin() ? SqlGetStockGroupId($strGroupItemId) : $this->_canModifyStockTransaction($strGroupItemId);
    			if ($strGroupId)
    			{
    				$trans_sql->DeleteById($strId);
    			}
    		}
    	}
    	else if ($strId = UrlGetQueryValue('adjust'))
    	{
    		$trans_sql = new StockTransactionSql();
    		if ($record = $trans_sql->GetRecordById($strId))
    		{
    			$strGroupItemId = $record['groupitem_id'];
   				if ($strGroupId = $this->_canModifyStockTransaction($strGroupItemId))
    			{
    				$strNetValue = UrlGetQueryValue('netvalue');
    				$trans_sql->Update($strId, $strGroupItemId, strval(floatval($record['quantity']) * floatval($record['price']) / floatval($strNetValue)), $strNetValue, $record['fees'], $record['remark']);
    			}
    		}
    	}
    	else if ($strId = UrlGetQueryValue('empty'))
    	{
    		$trans_sql = new StockTransactionSql();
    		if ($record = $trans_sql->GetRecordById($strId))
    		{
    			$strGroupItemId = $record['groupitem_id'];
   				if ($strGroupId = $this->_canModifyStockTransaction($strGroupItemId))
    			{
    				$trans_sql->Update($strId, $strGroupItemId, $record['quantity'], $record['price'], $record['fees']);
    			}
    		}
    	}
    	else if ($strGroupId = UrlGetQueryValue('groupid'))
    	{
    		$strGroupItemId = $this->_onAddFundPurchase($strGroupId);
    	}

    	UpdateStockGroupItem($strGroupId, $strGroupItemId);
    }
}

   	$acct = new _SubmitTransactionAccount();
	$acct->Run();
?>
