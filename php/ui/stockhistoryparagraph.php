<?php
require_once('stocktable.php');

function _echoStockHistoryItem($history, $ref, $csv)
{
	$strOpen = $ref->GetPriceDisplay(floatval($history['open']));
 	$strHigh = $ref->GetPriceDisplay(floatval($history['high']));
 	$strLow = $ref->GetPriceDisplay(floatval($history['low']));
 	$strClose = $ref->GetPriceDisplay(floatval($history['close']));
	$strAdjClose = $ref->GetPriceDisplay(floatval($history['adjclose']));
    echo <<<END
    <tr>
        <td class=c1>{$history['date']}</td>
        <td class=c1>$strOpen</td>
        <td class=c1>$strHigh</td>
        <td class=c1>$strLow</td>
        <td class=c1>$strClose</td>
        <td class=c1>{$history['volume']}</td>
        <td class=c1>$strAdjClose</td>
    </tr>
END;
}

function _echoStockHistoryData($sql, $ref, $csv, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoStockHistoryItem($history, $ref, $csv);
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
	$sql = new StockHistorySql($ref->GetStockId());
    if (IsTableCommonDisplay($iStart, $iNum))
    {
    	$strNavLink = '';
    }
    else
    {
    	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
    }
    
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
   
    _echoStockHistoryData($sql, $ref, $csv, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

?>
