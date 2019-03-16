<?php
require_once('stocktable.php');

function _echoStockTableItem($strStockId, $strDisplay, $bChinese)
{
    $record = SqlGetStockById($strStockId);
	$strSymbol = $record['name'];
//	if (empty($strSymbol))	$strSymbol = '(Unknown)';
	if (AcctIsAdmin())
	{
		$strLink = GetOnClickLink('/php/_submitdelete.php?stockid='.$strStockId, '确认删除股票'.$strSymbol.'?', $strSymbol);
	}
	else
	{
		$strLink = GetMyStockLink($strSymbol);
	}
    $strName = $bChinese ? $record['cn'] : $record['us'];

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strName</td>
        <td class=c1>$strDisplay</td>
    </tr>
END;
}

function _echoStockTableData($iStart, $iNum, $bChinese)
{
	if ($result = SqlGetAllStock($iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoStockTableItem($record['id'], ($bChinese ? $record['us'] : $record['cn']), $bChinese);
		}
		@mysql_free_result($result);
	}
}

function EchoStockParagraph($iStart, $iNum, $bChinese = true)
{
    $iTotal = SqlCountTableData(TABLE_STOCK);
    $strNavLink = GetNavLink(false, $iTotal, $iStart, $iNum, $bChinese);
    EchoParagraphBegin($strNavLink);
	$arReference = GetReferenceTableColumn($bChinese);
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stock">
        <tr>
            <td class=c1 width=100 align=center>{$arReference[0]}</td>
            <td class=c1 width=270 align=center>{$arReference[5]}</td>
            <td class=c1 width=270 align=center></td>
        </tr>
END;

	_echoStockTableData($iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}


?>
