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
        
        $strGroupName = $this->strName;
        if (($strGroupId = SqlGetStockGroupId($strGroupName, $strMemberId)) === false)
        {
            SqlInsertStockGroup($strMemberId, $strGroupName);
            $strGroupId = SqlGetStockGroupId($strGroupName, $strMemberId);
            if ($strGroupId)
            {
                foreach ($arRef as $ref)
                {
                    if ($ref->sym->IsIndex() == false)
                    {
                        SqlInsertStockGroupItem($strGroupId, $ref->GetStockId());
                    }
                }      
            }
        }
        parent::MyStockGroup($strGroupId, $arRef);
    }
}

?>
