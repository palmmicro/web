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
			$fShare = floatval($strShare);
			$ar[] = GetTurnoverDisplay($fVolume, $fShare);
			if (($fVolume > MIN_FLOAT_VAL) && ($fShareDiff > MIN_FLOAT_VAL))	$ar[] = GetTurnoverDisplay($fVolume, $fShareDiff, 0);
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
	$turnover_col = new TableColumnTurnover();
	$strSymbol = $ref->GetSymbol();
    if (IsTableCommonDisplay($iStart, $iNum))
    {
    	$str = GetMyStockLink($strSymbol).'的'.$quantity_col->GetDisplay().'相对于场内'.$share_col->GetDisplay().'的'.$turnover_col->GetDisplay().'比例';
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
 	
	EchoTableParagraphBegin(array(new TableColumnDate(), $share_col, new TableColumn(STOCK_OPTION_SHARE_DIFF, 110), $quantity_col, $turnover_col, new TableColumnTurnover('新增', 120)), 'fundshare', $str);
	$his_sql = GetStockHistorySql();
    if ($result = $shares_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result))		_echoFundShareItem($record, $strStockId, $his_sql, $shares_sql);
        @mysql_free_result($result);
    }
    EchoTableParagraphEnd($strMenuLink);
}

?>
