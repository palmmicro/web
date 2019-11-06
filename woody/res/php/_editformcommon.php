<?php
require_once('/php/ui/htmlelement.php');

function EditGetStockGroupItemList($strGroupId, $strCurGroupItemId)
{
	$sql = new StockGroupItemSql($strGroupId);
    if($ar = SqlGetStockGroupItemSymbolArray($sql))
    {
    	return HtmlGetOption($strCurGroupItemId ? array($strCurGroupItemId => $ar[$strCurGroupItemId]) : $ar);
    }
    return '';
}

?>
