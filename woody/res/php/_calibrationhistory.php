<?php
require_once('_stock.php');
require_once('/php/ui/stocktable.php');

function _echoCalibrationHistoryItem($strSymbol, $record, $bReadOnly)
{
    if ($bReadOnly)
    {
        $strDelete = '';
    }
    else
    {
        $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submitcalibration.php?delete='.$record['id'], '校准记录');
    }
    
    $strTime = substr($record['filled'], 0, 16);
    echo <<<END
    <tr>
        <td class=c1>$strSymbol</td>
        <td class=c1>{$record['price']}</td>
        <td class=c1>{$record['peername']}</td>
        <td class=c1>{$record['peerprice']}</td>
        <td class=c1>{$record['factor']}</td>
        <td class=c1>$strTime</td>
        <td class=c1>$strDelete</td>
    </tr>
END;
}

function _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum)
{
    if (AcctIsAdmin())
    {
        $bReadOnly = false;
    }
    else
    {
        $bReadOnly = true;
    }
    
    if ($result = SqlGetStockCalibration($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationHistoryItem($strSymbol, $record, $bReadOnly);
        }
        @mysql_free_result($result);
    }
}

function _echoCalibrationHistoryParagraph($strSymbol, $iStart, $iNum)
{
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  return;
    
	$strSymbolDisplay = GetTableColumnSymbol();
	$strPrice = GetTableColumnPrice();
	$arColumn = array($strSymbolDisplay, $strPrice, '对方'.$strSymbolDisplay, '对方'.$strPrice, '校准值', GetTableColumnTime(), '操作');
    
    $iTotal = SqlCountStockCalibration($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
    
    echo <<<END
   	<p>$strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="history">
    <tr>
        <td class=c1 width=90 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=90 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=100 align=center>{$arColumn[4]}</td>
        <td class=c1 width=150 align=center>{$arColumn[5]}</td>
        <td class=c1 width=50 align=center>{$arColumn[6]}</td>
    </tr>
END;
   
    _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoCalibrationHistory()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();
   		
        $iStart = UrlGetQueryInt('start');
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        _echoCalibrationHistoryParagraph($strSymbol, $iStart, $iNum);
    }
    EchoPromotionHead('calibration');
}

function EchoTitle()
{
    EchoUrlSymbol();
    echo '校准历史记录';
}

    AcctAuth();

?>

