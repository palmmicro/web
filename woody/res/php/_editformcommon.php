<?php

function EditGetStockGroupItemList($strGroupId, $strCurGroupItemId)
{
    if (($arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($strGroupId)) == false)   return '';
    
    $strSymbolsList = '';
    foreach ($arGroupItemSymbol as $strGroupItemId => $strSymbol)
    {
        if ($strCurGroupItemId)
        {
            if ($strCurGroupItemId != $strGroupItemId)  continue;
        }
        $strSymbolsList .= "<OPTION value=$strGroupItemId>$strSymbol</OPTION>";
    }
    return $strSymbolsList;
}

?>
