<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _adjustLofPriceFactor($strLofSymbol, $fLof, $fEst, $fCNY)
{
    $fFactor = $fEst * $fCNY / $fLof;
    return $fFactor;
}

function _adjustEtfPriceFactor($strEstSymbol, $fEst, $fEtf)
{
    $fFactor = $fEst / $fEtf;
    return $fFactor;
}

function _onAdjust($strSymbols)
{
    $ar = explode('&', $strSymbols);
    
    $ar0 = explode('=', $ar[0]);
    $strSymbol = $ar0[0];
    $fVal = floatval($ar0[1]);
    
    $ar1 = explode('=', $ar[1]);
    $strSymbol2 = $ar1[0];
    $fVal2 = floatval($ar1[1]);
    
    $iCount = count($ar);
    if ($iCount > 2)
    {
        $ar2 = explode('=', $ar[2]);
    }
    
    $fFactor = false;
    if (in_arrayLof($strSymbol) || in_arrayLofHk($strSymbol))
    {
        $fFactor = _adjustLofPriceFactor($strSymbol, $fVal, $fVal2, floatval($ar2[1]));
    }
    else if (in_arrayGoldEtf($strSymbol))
    {
        $fFactor = _adjustEtfPriceFactor($strSymbol, $fVal2, $fVal);
    }
    
    if ($fFactor !== false)
    {
        SqlInsertStockCalibration(SqlGetStockId($strSymbol), ' ', $ar0[1], $ar1[1], $fFactor, DebugGetDateTime());
    }
}

function _debugStockGroup($strGroupId, $strSymbols)
{
    $str = 'Stock Group: '.$_POST['submit'];
    $str .= '<br />GroupName: '.GetStockGroupLink($strGroupId); 
    $str .= '<br />Symbols: '.$strSymbols; 
    trigger_error($str); 
}

function _stockGetSymbolArray($strSymbols)
{
	$str = str_replace(array(',', '，', "\\n", "\\r", "\\r\\n"), ' ', $strSymbols);
    $ar = explode(' ', $str);
    return StockGetArraySymbol($ar);
}

function _getStockIdArray($strSymbols)
{
	$arStockId = array();
    $arSymbol = _stockGetSymbolArray($strSymbols);
	foreach ($arSymbol as $strSymbol)
	{
	    $strStockId = SqlGetStockId($strSymbol);
	    if ($strStockId == false)
	    {
            $ref = StockGetReference($strSymbol);
            if ($ref->HasData())
            {
            	$strStockId = $ref->GetStockId();
            }
            else
            {
            	continue;
            }
	    }
	    $arStockId[] = $strStockId; 
	}
	return $arStockId;
}

class _SubmitGroupAccount extends StockAccount
{
    function _onDelete($strGroupId)
    {
    	if ($this->IsAdmin() || ($this->IsGroupReadOnly($strGroupId) == false))
    	{
    		SqlDeleteStockGroupItemByGroupId($strGroupId);
    		SqlDeleteTableDataById(TABLE_STOCK_GROUP, $strGroupId);
    	}
    }
    
    function _onEdit($strLoginId, $strGroupName, $strSymbols)
    {
		$strGroupId = UrlGetQueryValue('edit');
    	if ($this->IsGroupReadOnly($strGroupId))  return;

    	$str = $this->GetGroupName($strGroupId);
    	if (in_arrayAll($str))  $strGroupName = $str;
    
//    	$sql = new StockGroupSql($strLoginId);
		$sql = $this->GetGroupSql();
    	if ($sql->Update($strGroupId, $strGroupName))
    	{
    		SqlUpdateStockGroup($strGroupId, _getStockIdArray($strSymbols));
    	}
    	_debugStockGroup($strGroupId, $strSymbols);
    }
    
    function _onNew($strLoginId, $strGroupName, $strSymbols)
    {
//    	$sql = new StockGroupSql($strLoginId);
		$sql = $this->GetGroupSql();
    	$sql->Insert($strGroupName);
    	if ($strGroupId = $sql->GetId($strGroupName))
    	{
    		$item_sql = new StockGroupItemSql($strGroupId);
    		$arStockId = _getStockIdArray($strSymbols);
    		foreach ($arStockId as $strStockId)
    		{
    			$item_sql->Insert($strStockId);
    		}
    	}
    	_debugStockGroup($strGroupId, $strSymbols);
    }
    
    public function Process($strLoginId)
    {
		if ($strGroupId = UrlGetQueryValue('delete'))
		{
			$this->_onDelete($strGroupId);
		}
		else if (isset($_POST['submit']))
		{
			$strSymbols = SqlCleanString($_POST['symbols']);
			$strGroupName = isset($_POST['groupname']) ? SqlCleanString($_POST['groupname']) : '';
			if (empty($strGroupName))	$strGroupName = '@'.md5(strval(rand()));

			switch ($_POST['submit'])
			{
			case STOCK_GROUP_ADJUST:
				if ($this->IsAdmin())		_onAdjust($strSymbols);
				break;

			case STOCK_GROUP_EDIT:
				$this->_onEdit($strLoginId, $strGroupName, $strSymbols);
				break;

			case STOCK_GROUP_NEW:
				$this->_onNew($strLoginId, $strGroupName, $strSymbols);
				break;
			}
			unset($_POST['submit']);
		}
	}
}

   	$acct = new _SubmitGroupAccount();
	$acct->Run();
?>
