<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/stocktable.php');

function _echoCalibrationHistoryItem($sql, $strStockId, $record)
{
	$ar = array();
	$strDate = $record['date'];
	
	$ar[] = $strDate;
	$ar[] = $sql->GetClose($strStockId, $strDate);
	$ar[] = $record['close'];
	$ar[] = $record['time'];

	EchoTableColumn($ar);
}

function _echoCalibrationHistoryParagraph($ref, $iStart, $iNum)
{
	$strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();
	$sql = GetNavHistorySql();
	if ($sql->Count($strStockId) == 0)
	{	// Symbol like USO do not have NAV 
		$sql = GetStockHistorySql();
		$nav_col = new TableColumnPrice();
	}
	else
	{
		$nav_col = new TableColumnNetValue();
	}

	$calibration_sql = new CalibrationSql();
   	$strMenuLink = StockGetMenuLink($strSymbol, $calibration_sql->Count($strStockId), $iStart, $iNum);
    
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   $nav_col,
								   new TableColumnCalibration(),
								   new TableColumnTime()
								   ), $strSymbol.TABLE_CALIBRATION_HISTORY, $strMenuLink);

    if ($result = $calibration_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
			_echoCalibrationHistoryItem($sql, $strStockId, $record);
        }
        @mysql_free_result($result);
    }
    EchoTableParagraphEnd($strMenuLink);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		_echoCalibrationHistoryParagraph($ref, $acct->GetStart(), $acct->GetNum());
    }
    $acct->EchoLinks(TABLE_CALIBRATION_HISTORY);
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

    $acct = new SymbolAccount();
   	$acct->Create();
?>

