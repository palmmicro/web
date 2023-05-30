<?php
require_once('stocktable.php');

function _echoFundPurchaseTableItem($strStockId, $strAmount, $bChinese)
{
	$strSymbol = SqlGetStockSymbol($strStockId);
    EchoTableColumn(array(GetMyStockLink($strSymbol), $strAmount));
}

function _echoFundPurchaseTableData($strMemberId, $iStart, $iNum, $bChinese)
{
	if ($result = SqlGetFundPurchase($strMemberId, $iStart, $iNum)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
			_echoFundPurchaseTableItem($record['stock_id'], $record['amount'], $bChinese);
		}
		mysqli_free_result($result);
	}
}

function EchoFundPurchaseParagraph($str, $strMemberId, $bChinese, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnAmount()
								   ), 'fund', $str);

	_echoFundPurchaseTableData($strMemberId, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd();
}

?>
