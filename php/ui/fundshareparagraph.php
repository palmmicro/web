<?php
require_once('stocktable.php');

function GetDiffDisplay($fDiff)
{
	$strColor = ($fDiff > MIN_FLOAT_VAL) ? 'green' : 'red';
	$strDisp = strval_round($fDiff, 2);
	if ($strDisp == '0')		$strColor = 'gray';

   	return GetFontElement($strDisp, $strColor);
}

function _echoFundShareItem($record, $strStockId, $his_sql, $shares_sql)
{
	$strDate = $record['date'];
   	$strShare = rtrim0($record['close']);
   	$ar = array($strDate, $strShare);
   	
	if ($strSharePrev = $shares_sql->GetClosePrev($strStockId, $strDate))
	{
		$fShareDiff = floatval($strShare) - floatval($strSharePrev);
    	$strVolume = $his_sql->GetVolume($strStockId, $strDate);
    	$fVolume = floatval($strVolume);
    	
		$ar[] = GetDiffDisplay($fShareDiff);
		$ar[] = $strVolume;
		if (!empty($strShare))
		{
			$ar[] = strval_round(100.0 * $fVolume / (floatval($strShare) * 10000.0), 2);
			if (($fVolume > MIN_FLOAT_VAL) && ($fShareDiff > MIN_FLOAT_VAL))	$ar[] = strval_round(100.0 * $fVolume / ($fShareDiff * 10000.0), 2);
		}
	}
	
	EchoTableColumn($ar);
}

function EchoFundShareParagraph($ref, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
	$shares_sql = new SharesHistorySql();
	$strStockId = $ref->GetStockId();
	if (($iTotal = $shares_sql->Count($strStockId)) == 0)	return;
	
	$share_col = new TableColumnShare();
	$quantity_col = new TableColumnQuantity();
	$percentage_col = new TableColumnTradingPercentage();
	$strSymbol = $ref->GetSymbol();
    if (IsTableCommonDisplay($iStart, $iNum))
    {
    	$str = GetMyStockLink($strSymbol).'场内'.$quantity_col->GetDisplay().'相对于'.$share_col->GetDisplay().'的'.$percentage_col->GetDisplay();
        $str .= ' '.GetFundShareLink($strSymbol);
        $strMenuLink = '';
    }
    else
	{
		$str = GetFundLinks($strSymbol);
		if ($bAdmin)	$str .= '<br />'.StockGetAllLink($strSymbol);
		$strMenuLink = StockGetMenuLink($strSymbol, $iTotal, $iStart, $iNum);
		$str .= ' '.$strMenuLink;
	}
 	
	EchoTableParagraphBegin(array(new TableColumnDate(), $share_col, new TableColumnShareDiff(), $quantity_col, $percentage_col, new TableColumnPercentage('新增换手', 120)), 'fundshare', $str);
	$his_sql = GetStockHistorySql();
    if ($result = $shares_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result))		_echoFundShareItem($record, $strStockId, $his_sql, $shares_sql);
        @mysql_free_result($result);
    }
    EchoTableParagraphEnd($strMenuLink);
}

?>
