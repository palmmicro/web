<?php
require_once('_stock.php');
require_once('_editgroupform.php');

function _getStockIdArray($strSymbols)
{
	$arStockId = array();
    $arSymbol = GetInputSymbolArray($strSymbols);
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

    	// 不修改有单独页面的分组名称
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
			case DISP_EDIT_CN:
				$this->_onEdit($strLoginId, $strGroupName, $strSymbols);
				break;

			case DISP_NEW_CN:
				$this->_onNew($strLoginId, $strGroupName, $strSymbols);
				break;
			}
			unset($_POST['submit']);
		}
	}
}

?>
