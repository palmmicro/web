<?php
require_once('/php/stockgroup.php');
require_once('/php/stockhis.php');

class _StockGroup extends MyStockGroup
{
    var $ref;                
    var $strName;            //  Group name
    
    function _StockGroup($arRef) 
    {
        $this->strName = $arRef[0]->GetSymbol();
        $strMemberId = AcctIsLogin();
        if ($strMemberId == false)     return;
        
        $sql = new StockGroupSql($strMemberId);
        $strGroupName = $this->strName;
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
        parent::MyStockGroup($strGroupId, $arRef);
    }
}

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
