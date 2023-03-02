<?php
require_once('stocktable.php');

function _echoStockTableItem($strSymbol, $strName, $bAdmin)
{
	$ar = array(GetMyStockLink($strSymbol), GetXueqiuLink(new StockSymbol($strSymbol), $strName));
	if ($bAdmin)
	{
		$ar[] = GetStockEditDeleteLink($strSymbol);
	}

	EchoTableColumn($ar);
}

function _echoStockTableData($sql, $iStart, $iNum, $bAdmin)
{
	if ($result = $sql->GetAll($iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoStockTableItem($record['symbol'], $record['name'], $bAdmin);
		}
		@mysql_free_result($result);
	}
}

function EchoStockParagraph($iStart, $iNum, $bAdmin)
{
	$sql = GetStockSql();
    $strMenuLink = GetMenuLink(false, $sql->CountData(), $iStart, $iNum);
    
	$ar = array(new TableColumnSymbol(), new TableColumnName());
	if ($bAdmin)
	{
		$ar[] = new TableColumn('', 270);
	}
	EchoTableParagraphBegin($ar, 'stock', $strMenuLink);

	_echoStockTableData($sql, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strMenuLink);
}

?>
