<?php
require_once('/php/ui/htmlelement.php');

function EditGetStockGroupItemList($strGroupId, $strCurGroupItemId)
{
	$sql = new StockGroupItemSql($strGroupId);
    $ar = SqlGetStockGroupItemSymbolArray($sql);
    if ($ar == false)   return '';

    if ($strCurGroupItemId)		return HtmlGetOption(array($strCurGroupItemId => $ar[$strCurGroupItemId]));
    return HtmlGetOption($ar);
}

?>
