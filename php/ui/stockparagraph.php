<?php
require_once('stocktable.php');

function _echoStockTableItem($strStockId, $strSymbol, $strName)
{
	$ar = array();
	
	$ar[] = GetMyStockLink($strSymbol);
	$ar[] = $strName;
	if (AcctIsAdmin())
	{
		$strEdit = GetStockOptionLink(STOCK_OPTION_EDIT, $strSymbol);
        $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_deletesymbol.php?symbol='.$strSymbol, '股票'.$strSymbol);
        $ar[] = $strEdit.' '.$strDelete;
	}
	else
	{
		$ar[] = '';
	}

	EchoTableColumn($ar);
}

function _echoStockTableData($sql, $iStart, $iNum)
{
	if ($result = $sql->GetAll($iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoStockTableItem($record['id'], $record['symbol'], $record['name']);
		}
		@mysql_free_result($result);
	}
}

function EchoStockParagraph($iStart, $iNum)
{
	$sql = new StockSql();
    $strNavLink = GetNavLink(false, $sql->CountData(), $iStart, $iNum);
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnName(),
								   new TableColumn('', 270)
								   ), 'stock', $strNavLink);

	_echoStockTableData($sql, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

?>
