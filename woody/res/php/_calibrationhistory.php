<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('../../php/ui/stocktable.php');

function _echoCalibrationHistoryItem($sql, $fPosition, $strStockId, $record, $bAdmin)
{
	$ar = array();
	$strDate = $record['date'];
	
	$ar[] = $strDate;
	$ar[] = $sql->GetClose($strStockId, $strDate);
	
	$strCalibration = $record['close']; 
	$ar[] = $strCalibration;
	
	$ar[] = $record['time'];
	
	$strArbitrage = strval(round(floatval($strCalibration) / $fPosition));
	if ($bAdmin)	$strArbitrage = GetOnClickLink('/php/_submitoperation.php?stockid='.$strStockId.'&fundarbitrage='.$strArbitrage, "确认使用{$strArbitrage}作为参考对冲值？", $strArbitrage);
	$ar[] = $strArbitrage; 

	EchoTableColumn($ar);
}

function _echoCalibrationHistoryParagraph($ref, $iStart, $iNum, $bAdmin)
{
	$strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();
	
	$calibration_sql = new CalibrationSql();
   	$strMenuLink = StockGetMenuLink($strSymbol, $calibration_sql->Count($strStockId), $iStart, $iNum);
   	$str = GetFundLinks($strSymbol);
    
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   RefGetTableColumnNav($ref),
								   new TableColumnCalibration(),
								   new TableColumnTime(),
								   new TableColumn('对冲值')
								   ), $strSymbol.'calibrationhistory', $str.' '.$strMenuLink);

    if ($result = $calibration_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
    	$sql = ($ref->CountNav() > 0) ? GetNavHistorySql() : GetStockHistorySql(); 
    	$fPosition = RefGetPosition($ref);
        while ($record = mysql_fetch_assoc($result)) 
        {
			_echoCalibrationHistoryItem($sql, $fPosition, $strStockId, $record, $bAdmin);
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
   		_echoCalibrationHistoryParagraph($ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks('calibrationhistory');
}    

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(CALIBRATION_HISTORY_DISPLAY);
    $str .= '页面。用于查看、比较和调试估算的股票价格和基金净值之间的校准情况。最新校准时间会直接显示在该基金页面。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(CALIBRATION_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();
?>

