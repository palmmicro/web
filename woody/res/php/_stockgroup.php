<?php
require_once('/php/stockgroup.php');
require_once('/php/stockhis.php');

class GroupAccount extends StockAccount
{
    var $group = false;	//  MyStockGroup
	
    function GroupAccount() 
    {
        parent::StockAccount();
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
    	if (($strLoginId = $this->GetLoginId()) == false)		return;
    	
        $sql = new StockGroupSql($strLoginId);
        $strGroupName = $this->GetName();
        if ($strGroupId = $sql->GetId($strGroupName))
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
			$sql->Insert($strGroupName);
            if ($strGroupId = $sql->GetId($strGroupName))
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
}

?>
