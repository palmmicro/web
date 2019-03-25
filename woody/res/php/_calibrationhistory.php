<?php
require_once('_stock.php');
require_once('/php/ui/stocktable.php');

function _echoCalibrationHistoryItem($strSymbol, $history, $bReadOnly, $bChinese)
{
    if ($bReadOnly)
    {
        $strDelete = '';
    }
    else
    {
        $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submitcalibration.php?delete='.$history['id'], '校准记录', 'calibration record', $bChinese);
    }
    
    $strTime = substr($history['filled'], 0, 16);
    echo <<<END
    <tr>
        <td class=c1>$strSymbol</td>
        <td class=c1>{$history['price']}</td>
        <td class=c1>{$history['peername']}</td>
        <td class=c1>{$history['peerprice']}</td>
        <td class=c1>{$history['factor']}</td>
        <td class=c1>$strTime</td>
        <td class=c1>$strDelete</td>
    </tr>
END;
}

function _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum, $bChinese)
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
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationHistoryItem($strSymbol, $history, $bReadOnly, $bChinese);
        }
        @mysql_free_result($result);
    }
}

function _echoCalibrationHistoryParagraph($strSymbol, $iStart, $iNum, $bChinese)
{
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  return;
    
	$strSymbolDisplay = GetTableColumnSymbol();
	$strPrice = GetTableColumnPrice();
	$arColumn = array($strSymbolDisplay, $strPrice, '对方'.$strSymbolDisplay, '对方'.$strPrice, '校准值', '时间', '操作');
    
    $iTotal = SqlCountStockCalibration($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
    
    EchoParagraphBegin($strNavLink);
    echo <<<END
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
   
    _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

function EchoCalibrationHistory($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();
   		
        $iStart = UrlGetQueryInt('start');
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        _echoCalibrationHistoryParagraph($strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead('calibration');
}

function EchoTitle($bChinese = true)
{
    EchoUrlSymbol();
    if ($bChinese)  echo '校准历史记录';
    else              echo ' Calibration History';
}

    AcctAuth();

?>

