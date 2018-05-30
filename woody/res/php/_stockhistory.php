<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

function _echoStockHistoryItem($history)
{
    echo <<<END
    <tr>
        <td class=c1>{$history['date']}</td>
        <td class=c1>{$history['open']}</td>
        <td class=c1>{$history['high']}</td>
        <td class=c1>{$history['low']}</td>
        <td class=c1>{$history['close']}</td>
        <td class=c1>{$history['volume']}</td>
        <td class=c1>{$history['adjclose']}</td>
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

function _echoStockHistoryParagraph($strSymbol, $strStockId, $iStart, $iNum, $bAdmin, $bChinese)
{
    if ($bChinese)  $arColumn = array('日期', '开盘价', '最高', '最低', '收盘价', '成交量', '复权收盘价');
    else              $arColumn = array('Date', 'Open', 'High', 'Low', 'Close', 'Volume', 'Adj Close');
    
    $strUpdateLink = ''; 
    if ($bAdmin)
    {
        $strUpdateLink = GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strStockId, $bChinese ? '确认更新股票历史记录?' : 'Confirm update stock history?', $bChinese ? '更新历史记录' : 'Update History');
        $strUpdateLink .= ' '.SqlCountTableDataString(TABLE_STOCK_HISTORY);
        $sym = new StockSymbol($strSymbol);
        if ($sym->IsIndexA())		$strUpdateLink .= ' '.GetSinaStockHistoryLink($strSymbol);
        else				        $strUpdateLink .= ' '.GetYahooStockHistoryLink($strSymbol);
    }

	$sql = new SqlStockHistory($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
    $strSymbolLink = GetMyStockLink($strSymbol, $bChinese);
    EchoParagraphBegin($strSymbolLink.' '.$strNavLink.' '.$strUpdateLink);
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="history">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=80 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=110 align=center>{$arColumn[5]}</td>
        <td class=c1 width=110 align=center>{$arColumn[6]}</td>
    </tr>
END;
   
    _echoStockHistoryData($sql, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoStockHistory($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$bAdmin = AcctIsAdmin();
    		_echoStockHistoryParagraph($strSymbol, $strStockId, $iStart, $iNum, $bAdmin, $bChinese);
    		if ($bAdmin && $bChinese && $iStart == 0)
    		{
				StockOptionEditForm(STOCK_OPTION_ADJCLOSE_CN);
    		}
    	}
    }
    EchoPromotionHead('', $bChinese);
}

function EchoTitle($bChinese)
{
    EchoUrlSymbol();
    if ($bChinese)  echo '历史价格记录';
    else              echo ' History Price';
}

    AcctAuth();

?>
