<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/stock/szse.php');

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

function _echoFundShareParagraph($ref, $iStart, $iNum, $bAdmin)
{
	$shares_sql = new SharesHistorySql();
	$strStockId = $ref->GetStockId();
	$strSymbol = $ref->GetSymbol();
 	$str = GetFundLinks($strSymbol);
    if ($bAdmin)	$str .= '<br />'.StockGetAllLink($strSymbol);
    $strMenuLink = StockGetMenuLink($strSymbol, $shares_sql->Count($strStockId), $iStart, $iNum);
 	
	EchoTableParagraphBegin(array(new TableColumnDate(),
				   				   new TableColumnShare(),
				   				   new TableColumnShareDiff(),
				   				   new TableColumnQuantity(),
								   new TableColumnTradingPercentage(),
				   				   new TableColumnPercentage('新增换手', 120)
				   				   ), FUND_SHARE_PAGE, $str.' '.$strMenuLink);
	
	$his_sql = GetStockHistorySql();
    if ($result = $shares_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		_echoFundShareItem($record, $strStockId, $his_sql, $shares_sql);
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
        SzseGetLofShares($ref);
       _echoFundShareParagraph($ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks(FUND_SHARE_PAGE);
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(FUND_SHARE_DISPLAY);
    $str .= '。显示基金场内份额、当日新增和当日成交量等相关信息。主要用来判断当日新增份额的套利党出货情况。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(FUND_SHARE_DISPLAY);
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

