<?php
require_once('stocktable.php');

function _echoStockTableItem($strStockId, $strSymbol, $strName)
{
	$strLink = GetMyStockLink($strSymbol);
	if (AcctIsAdmin())
	{
		$strEdit = GetStockOptionLink(STOCK_OPTION_EDIT, $strSymbol);
        $strDelete = GetDeleteLink('/php/_submitdelete.php?stockid='.$strStockId, '股票'.$strSymbol);
	}

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strName</td>
        <td class=c1>$strEdit $strDelete</td>
    </tr>
END;
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
	$arReference = GetReferenceTableColumn();
    echo <<<END
    	<p>$strNavLink
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stock">
        <tr>
            <td class=c1 width=100 align=center>{$arReference[0]}</td>
            <td class=c1 width=270 align=center>{$arReference[5]}</td>
            <td class=c1 width=270 align=center></td>
        </tr>
END;

	_echoStockTableData($sql, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}


?>
