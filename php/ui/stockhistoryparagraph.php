<?php
require_once('stocktable.php');

function _echoStockHistoryItem($history)
{
 	$strOpen = GetTableColumnFloatDisplay($history['open']);
 	$strHigh = GetTableColumnFloatDisplay($history['high']);
 	$strLow = GetTableColumnFloatDisplay($history['low']);
 	$strClose = GetTableColumnFloatDisplay($history['close']);
	$strAdjClose = GetTableColumnFloatDisplay($history['adjclose']);
    echo <<<END
    <tr>
        <td class=c1>{$history['date']}</td>
        $strOpen
        $strHigh
        $strLow
        $strClose
        <td class=c1>{$history['volume']}</td>
        $strAdjClose
    </tr>
END;
}

function _echoStockHistoryData($sql, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoStockHistoryItem($history);
        }
        @mysql_free_result($result);
    }
}

function EchoStockHistoryParagraph($ref, $bChinese, $str = '', $csv = false, $iStart = 0, $iNum = 1)
{
	$arReference = GetReferenceTableColumn($bChinese);
	$strPrice = $arReference[1];
	$strDate = $arReference[3];
    if ($bChinese)  $arColumn = array($strDate, '开盘价', '最高', '最低', $strPrice, '成交量', '复权收盘价');
    else              $arColumn = array($strDate, 'Open',   'High', 'Low',  $strPrice, 'Volume', 'Adj Close');

	$sql = new StockHistorySql($ref->GetStockId());
    if ($iStart == 0 && $iNum == 1)
    {
    	$strNavLink = '';
    }
    else
    {
    	$strNavLink = StockGetNavLink($ref->GetStockSymbol(), $sql->Count(), $iStart, $iNum, $bChinese);
    }
    
    echo <<<END
    <p>$strNavLink $str
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stockhistory">
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
   
    _echoStockHistoryData($sql, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

?>
