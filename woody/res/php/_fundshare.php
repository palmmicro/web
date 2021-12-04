<?php
require_once('_stock.php');
require_once('_emptygroup.php');

function GetDiffDisplay($fDiff)
{
	$strColor = ($fDiff > MIN_FLOAT_VAL) ? 'black' : 'red';
	$strDisp = strval_round($fDiff, 2);
	if ($strDisp == '0')		$strColor = 'gray';

   	return "<font color=$strColor>$strDisp</font>";
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

function _echoFundShareParagraph($ref, $iStart, $iNum)
{
	$shares_sql = new SharesHistorySql();
	$strStockId = $ref->GetStockId();
	$strSymbol = $ref->GetSymbol();
 	$str = GetFundLinks($strSymbol);
    $strNavLink = StockGetNavLink($strSymbol, $shares_sql->Count($strStockId), $iStart, $iNum);
 	
	EchoTableParagraphBegin(array(new TableColumnDate(),
				   				   new TableColumnShare(),
				   				   new TableColumnShareDiff(),
				   				   new TableColumnQuantity(),
								   new TableColumnTradingPercentage(),
				   				   new TableColumnPercentage('新增换手', 120)
				   				   ), FUND_SHARE_PAGE, $str.' '.$strNavLink);
	
	$his_sql = GetStockHistorySql();
    if ($result = $shares_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		_echoFundShareItem($record, $strStockId, $his_sql, $shares_sql);
        }
        @mysql_free_result($result);
    }
	
    EchoTableParagraphEnd($strNavLink);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
        SzseGetLofShares($ref);
       _echoFundShareParagraph($ref, $acct->GetStart(), $acct->GetNum());
    }
    $acct->EchoLinks(FUND_SHARE_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_SHARE_DISPLAY;
    $str .= '. 仅用于华宝油气(SZ162411)等深市LOF基金, 以及少数XOP等美股SPDR基金. 显示场内份额, 当日新增和当日成交量等相关信息.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().FUND_SHARE_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

