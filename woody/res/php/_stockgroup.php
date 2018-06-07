<?php
require_once('/php/stockgroup.php');

class _StockGroup extends MyStockGroup
{
    var $ref;                
    var $strName;            //  Group name
    
    // constructor 
    function _StockGroup($arRef) 
    {
        $this->strName = $arRef[0]->GetStockSymbol();
        $strMemberId = AcctIsLogin();
        if ($strMemberId == false)     return;
        
        $sql = new StockGroupSql($strMemberId);
        $strGroupName = $this->strName;
        if ($strGroupId = $sql->GetTableId($strGroupName))
        {
        	$arNew = array();
            foreach ($arRef as $ref)
            {
                if ($ref->sym->IsTradable())
                {
                	$arNew[] = $ref->GetStockId();
                }
            }      
            SqlUpdateStockGroup($strGroupId, $arNew);
        }
        else
        {
			$sql->Insert($strGroupName);
            if ($strGroupId = $sql->GetTableId($strGroupName))
            {
            	$item_sql = new StockGroupItemSql($strGroupId);
                foreach ($arRef as $ref)
                {
                    if ($ref->sym->IsTradable())
                    {
                    	$item_sql->Insert($ref->GetStockId());
                    }
                }      
            }
        }
        parent::MyStockGroup($strGroupId, $arRef);
    }
}

?>
