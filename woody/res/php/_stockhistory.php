<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

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

function _echoStockHistoryParagraph($strSymbol, $strStockId, $iStart, $iNum, $bTest, $bChinese)
{
    if ($bChinese)  $arColumn = array('日期', '开盘价', '最高', '最低', '收盘价', '成交量', '复权收盘价');
    else              $arColumn = array('Date', 'Open', 'High', 'Low', 'Close', 'Volume', 'Adj Close');
    
    $sym = new StockSymbol($strSymbol);
    $strLinks = GetStockHistoryLink($sym, $bChinese);
    if ($sym->IsTradable())			$strLinks .= ' '.GetStockDividendLink($sym, $bChinese);
    
    if ($bTest)
    {
        $strLinks .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strStockId, $bChinese ? '确认更新股票历史记录?' : 'Confirm update stock history?', $bChinese ? '更新历史记录' : 'Update History');
        $strLinks .= ' '.SqlCountTableDataString(TABLE_STOCK_HISTORY);
    }

	$sql = new StockHistorySql($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
    echo <<<END
    <p>$strNavLink $strLinks
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

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$bTest = AcctIsAdmin();
    		_echoStockHistoryParagraph($strSymbol, $strStockId, $iStart, $iNum, $bTest, $bChinese);
    		if ($bTest && $iStart == 0)
    		{
				StockOptionEditForm($bChinese ? STOCK_OPTION_ADJCLOSE_CN : STOCK_OPTION_ADJCLOSE);
    		}
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '历史价格记录' : ' Historical Price');
}

    AcctAuth();

?>
