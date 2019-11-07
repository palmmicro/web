<?php
require_once('/php/stockgroup.php');
require_once('/php/stockhis.php');

class _StockGroup extends MyStockGroup
{
    var $ref;                
    var $strName;            //  Group name
    
    function _StockGroup($arRef) 
    {
        $this->strName = $arRef[0]->GetStockSymbol();
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

?>
