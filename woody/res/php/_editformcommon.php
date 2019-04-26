<?php
/*
function _getStockSymbolVal($sym)
{
	if ($sym->IsSymbolA())			return 0;
    else if ($sym->IsSymbolH())		return 2;
    return 1;
}

function _sortGroupItemSymbol($str1, $str2)
{
   	$sym1 = new StockSymbol($str1);
   	$sym2 = new StockSymbol($str2);
   	$iVal1 = _getStockSymbolVal($sym1);
   	$iVal2 = _getStockSymbolVal($sym2);
   	if ($iVal1 == $iVal2)	return 0;
   	return ($iVal1 < $iVal2) ? -1 : 1;
}
*/
function EditGetStockGroupItemList($strGroupId, $strCurGroupItemId)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($sql);
    if ($arGroupItemSymbol == false)   return '';
    
//    uasort($arGroupItemSymbol, '_sortGroupItemSymbol');
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
