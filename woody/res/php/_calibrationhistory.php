<?php
require_once('_stock.php');
require_once('_emptygroup.php');
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

function _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum, $bAdmin)
{
    if ($bAdmin)
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

function _echoCalibrationHistoryParagraph($strSymbol, $iStart, $iNum, $bAdmin)
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
   
    _echoCalibrationHistoryData($strStockId, $strSymbol, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	if ($ref->HasData())
    	{
    		_echoCalibrationHistoryParagraph($ref->GetStockSymbol(), $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    	}
    }
    $acct->EchoLinks('calibration');
}    

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().CALIBRATION_HISTORY_DISPLAY;
    $str .= '页面. 用于查看, 比较和调试估算的股票价格或者基金净值之间的校准情况. 最新的校准时间一般会直接显示在该股票或者基金的页面, 提供更明显的调试信息.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
  	echo $acct->GetSymbolDisplay().CALIBRATION_HISTORY_DISPLAY;
}

    $acct = new SymbolAcctStart();

?>

