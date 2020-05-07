<?php
require_once('stocktable.php');

function _echoStockTableItem($strStockId, $strSymbol, $strName, $bAdmin)
{
	$ar = array();
	
	$ar[] = GetMyStockLink($strSymbol);
	$ar[] = $strName;
	if ($bAdmin)
	{
		$strEdit = GetStockOptionLink(STOCK_OPTION_EDIT, $strSymbol);
        $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_deletesymbol.php?symbol='.$strSymbol, '股票'.$strSymbol);
        $ar[] = $strEdit.' '.$strDelete;
	}

	EchoTableColumn($ar);
}

function _echoStockTableData($sql, $iStart, $iNum, $bAdmin)
{
	if ($result = $sql->GetAll($iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoStockTableItem($record['id'], $record['symbol'], $record['name'], $bAdmin);
		}
		@mysql_free_result($result);
	}
}

function EchoStockParagraph($iStart, $iNum, $bAdmin)
{
	$sql = new StockSql();
    $strNavLink = GetNavLink(false, $sql->CountData(), $iStart, $iNum);
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnName(),
								   new TableColumn('', 270)
								   ), TABLE_STOCK, $strNavLink);

	_echoStockTableData($sql, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

?>
