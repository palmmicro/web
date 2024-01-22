<?php
require_once('../../php/stockgroup.php');

class GroupIdAccount extends StockAccount
{
    public function __construct() 
    {
        parent::__construct('groupid');
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
    		if ($strMemberId = $this->GetGroupMemberId($strGroupId))
    		{
    			return $this->GetGroupName($strGroupId).'【'.$this->GetWhoseDisplay($strMemberId).'】'; 
    		}
    		return '';
    	}
    	return $this->GetWhoseAllDisplay();
    }
}

?>
