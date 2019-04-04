<?php
require_once('stocktable.php');

function _echoStockHistoryItem($record, $ref, $csv)
{
	$strOpen = $ref->GetPriceDisplay(floatval($record['open']));
 	$strHigh = $ref->GetPriceDisplay(floatval($record['high']));
 	$strLow = $ref->GetPriceDisplay(floatval($record['low']));
 	$strClose = $ref->GetPriceDisplay(floatval($record['close']));
	$strAdjClose = $ref->GetPriceDisplay(floatval($record['adjclose']));
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

function EchoStockHistoryParagraph($ref, $str = '', $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$strDate = GetTableColumnDate();
    $arFundHistory = GetFundHistoryTableColumn(false);
    $strClose = $arFundHistory[1];
    $arColumn = array($strDate, '开盘价', '最高', '最低', $strClose, '成交量', '复权'.$strClose);

    $strSymbol = $ref->GetStockSymbol();
    $strNavLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetNavLink($strSymbol, $ref->his_sql->Count(), $iStart, $iNum);
    
    echo <<<END
    <p>$strNavLink $str
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="{$strSymbol}stockhistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=70 align=center>{$arColumn[4]}</td>
        <td class=c1 width=130 align=center>{$arColumn[5]}</td>
        <td class=c1 width=130 align=center>{$arColumn[6]}</td>
    </tr>
END;
   
    _echoStockHistoryData($ref, $csv, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

?>
