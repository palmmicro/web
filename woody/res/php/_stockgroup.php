<?php
require_once('../../php/stockgroup.php');
require_once('../../php/stockhis.php');
require_once('../../php/stock/chinamoney.php');
require_once('../../php/stock/szse.php');

class GroupAccount extends StockAccount
{
    var $group = false;	//  MyStockGroup
    var $arStockRef = array();
	
    function GetStockRefArray()
    {
    	return $this->arStockRef;
    }
    
    function GetGroup()
    {
    	return $this->group;
    }
    
    function GetGroupId()
    {
    	if ($group = $this->GetGroup())
    	{
    		return $group->GetGroupId();
    	}
    	return false;
    }
    
    function CreateGroup($arRef)
    {
    	foreach ($arRef as $ref)
        {
           	$this->arStockRef[] = $ref;
        }      
    	
    	if (($strLoginId = $this->GetLoginId()) == false)		return;

        $sql = $this->GetGroupSql();
        $strGroupName = $this->GetName();
        if ($strGroupId = $sql->GetRecordId($strLoginId, $strGroupName))
        {
        	$arNew = array();
            foreach ($arRef as $ref)
            {
            	$arNew[] = $ref->GetStockId();
            }      
            SqlUpdateStockGroup($strGroupId, $arNew);
        }
        else
        {
			$sql->InsertString($strLoginId, $strGroupName);
            if ($strGroupId = $sql->GetRecordId($strLoginId, $strGroupName))
            {
            	$item_sql = new StockGroupItemSql($strGroupId);
                foreach ($arRef as $ref)
                {
                	$item_sql->Insert($ref->GetStockId());
                }      
            }
        }
        
        if ($strGroupId)		$this->group = new MyStockGroup($strGroupId, $arRef);
    }
    
    function EchoTransaction()
    {
    	if ($group = $this->GetGroup()) 
    	{
    		if ($this->EchoStockTransaction($group))
    		{
    			return $group;
    		}
        }
        return false;
	}
}

?>
