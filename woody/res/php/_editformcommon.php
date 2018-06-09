<?php

function EditGetStockGroupItemList($strGroupId, $strCurGroupItemId)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($sql);
    if ($arGroupItemSymbol == false)   return '';
    
    $strSymbolsList = '';
    foreach ($arGroupItemSymbol as $strGroupItemId => $strSymbol)
    {
        if ($strCurGroupItemId)
        {
            if ($strCurGroupItemId != $strGroupItemId)  continue;
        }
        
        $sym = new StockSymbol($strSymbol);
        if ($sym->IsTradable())
        {
        	$strSymbolsList .= "<OPTION value=$strGroupItemId>$strSymbol</OPTION>";
        }
    }
    return $strSymbolsList;
}

?>
