<?php
require_once('/php/stockgroup.php');

class GroupIdAccount extends StockAccount
{
    function GroupIdAccount() 
    {
        parent::StockAccount('groupid');
    }
    
    function GetGroupId()
    {
    	$strGroupId = $this->GetQuery();
    	if (is_numeric($strGroupId) == false)		return false;
    	
    	return $strGroupId; 
    }
    
    function EchoStockGroup()
    {
    	if ($strGroupId = $this->GetGroupId())
    	{
    		EchoStockGroupParagraph($this, $strGroupId);
    	}
    	return $strGroupId;
    }
    
    function GetWhoseGroupDisplay()
    {
    	if ($strGroupId = $this->GetGroupId())
    	{
    		if ($strMemberId = SqlGetStockGroupMemberId($strGroupId))
    		{
    			return $this->GetWhoseDisplay($strMemberId).SqlGetStockGroupName($strGroupId); 
    		}
    		return '';
    	}
    	return $this->GetWhoseAllDisplay();
    }
}

?>
