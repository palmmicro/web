<?php
require_once('stocktable.php');

function _echoStockHistoryItem($record, $ref, $csv)
{
	$strPrev = $ref->GetPrevPrice();
	$strOpen = $ref->GetPriceDisplay($record['open'], $strPrev);
 	$strHigh = $ref->GetPriceDisplay($record['high'], $strPrev);
 	$strLow = $ref->GetPriceDisplay($record['low'], $strPrev);
 	$strClose = $ref->GetPriceDisplay($record['close'], $strPrev);
	$strAdjClose = $ref->GetPriceDisplay($record['adjclose'], $strPrev);
    echo <<<END
    <tr>
        <td class=c1>{$record['date']}</td>
        <td class=c1>$strOpen</td>
        <td class=c1>$strHigh</td>
        <td class=c1>$strLow</td>
        <td class=c1>$strClose</td>
        <td class=c1>{$record['volume']}</td>
        <td class=c1>$strAdjClose</td>
    </tr>
END;
}

function _echoStockHistoryData($ref, $csv, $iStart, $iNum)
{
    if ($result = $ref->his_sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoStockHistoryItem($record, $ref, $csv);
        }
        @mysql_free_result($result);
    }
}

function EchoStockHistoryParagraph($ref, $str = false, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    $strSymbol = $ref->GetStockSymbol();
	if ($str == false)	$str = GetStockHistoryLink($strSymbol);
    $strNavLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetNavLink($strSymbol, $ref->his_sql->Count(), $iStart, $iNum);
    
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumn(STOCK_DISP_OPEN),
								   new TableColumn(STOCK_DISP_HIGH),
								   new TableColumn(STOCK_DISP_LOW),
								   new TableColumnClose(),
								   new TableColumn(STOCK_DISP_QUANTITY, 130),
								   new TableColumnClose('复权')
								   ), $strSymbol.TABLE_STOCK_HISTORY, $str.'<br />'.$strNavLink);
   
    _echoStockHistoryData($ref, $csv, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

?>
