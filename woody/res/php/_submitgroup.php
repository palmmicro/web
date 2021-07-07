<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _adjustQdiiPriceFactor($strQdiiSymbol, $fQdii, $fEst, $fCNY)
{
    $fFactor = $fEst * $fCNY / $fQdii;
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

    list($strDummy, $strDate) = explode('=', $ar[0]);
    
    $ar1 = explode('=', $ar[1]);
    $strSymbol = $ar1[0];
    $fVal = floatval($ar1[1]);
    
    $ar2 = explode('=', $ar[2]);
    $strSymbol2 = $ar2[0];
    $fVal2 = floatval($ar2[1]);
    
    $iCount = count($ar);
    if ($iCount > 3)
    {
        $ar3 = explode('=', $ar[3]);
    }
    
    $fFactor = false;
    if (in_arrayQdii($strSymbol) || in_arrayQdiiHk($strSymbol))
    {
        $fFactor = _adjustQdiiPriceFactor($strSymbol, $fVal, $fVal2, floatval($ar3[1]));
    }
    else if (in_arrayGoldSilver($strSymbol))
    {
        $fFactor = _adjustEtfPriceFactor($strSymbol, $fVal2, $fVal);
    }
    
    if ($fFactor !== false)
    {
      	$calibration_sql = new CalibrationSql();
    	$calibration_sql->WriteDaily(SqlGetStockId($strSymbol), $strDate, strval($fFactor));
    }
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
//    		SqlDeleteTableDataById(TABLE_STOCK_GROUP, $strGroupId);
			$sql = $this->GetGroupSql();
			$sql->DeleteById($strGroupId);
    	}
    }
    
    function _debugStockGroup($strGroupId, $strSymbols)
    {
    	$str = 'Stock Group: '.$_POST['submit'];
    	$str .= '<br />GroupName: '.$this->GetGroupLink($strGroupId); 
    	$str .= '<br />Symbols: '.$strSymbols; 
    	trigger_error($str); 
    }

    function _onEdit($strLoginId, $strGroupName, $strSymbols)
    {
		$strGroupId = UrlGetQueryValue('edit');
    	if ($this->IsGroupReadOnly($strGroupId))  return;

    	$str = $this->GetGroupName($strGroupId);
    	if (in_arrayAll($str))  $strGroupName = $str;
    
		$sql = $this->GetGroupSql();
    	if ($sql->UpdateString($strGroupId, $strGroupName))
    	{
    		SqlUpdateStockGroup($strGroupId, _getStockIdArray($strSymbols));
    	}
    	$this->_debugStockGroup($strGroupId, $strSymbols);
    }
    
    function _onNew($strLoginId, $strGroupName, $strSymbols)
    {
		$sql = $this->GetGroupSql();
    	$sql->InsertString($strLoginId, $strGroupName);
    	if ($strGroupId = $sql->GetRecordId($strLoginId, $strGroupName))
    	{
    		$item_sql = new StockGroupItemSql($strGroupId);
    		$arStockId = _getStockIdArray($strSymbols);
    		foreach ($arStockId as $strStockId)
    		{
    			$item_sql->Insert($strStockId);
    		}
    	}
    	$this->_debugStockGroup($strGroupId, $strSymbols);
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
