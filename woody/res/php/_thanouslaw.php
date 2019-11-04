<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousLawCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[2]), floatval($arWord[1]));
    }
}

function _echoThanousLawPool($strSymbol, $strTradingSymbol)
{
   	$csv = new _ThanousLawCsvFile();
   	$csv->Read();
   	EchoParagraph($csv->GetLink());
   	EchoPricePoolParagraph($csv->pool, $strSymbol, $strTradingSymbol, false);
}

function _echoThanousLawItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref)
{
	$his_sql = $est_ref->GetHistorySql();
	$strEstClose = $his_sql->GetClose($strDate);
	$strEstClosePrev = $his_sql->GetClosePrev($strDate);
	if (($strEstClose == false) || ($strEstClosePrev == false))		return;
	
   	$csv->Write($strDate, $est_ref->GetPercentage($strEstClosePrev, $strEstClose), $ref->GetPercentage($strNetValue, $strClose), $strNetValue);
   	
   	$ar = array($strDate);
   	$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
   	$ar[] = $strNetValue;
	$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $ar[] = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);
    $ar[] = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
	EchoTableColumn($ar);
}

function _echoThanousLawData($sql, $ref, $est_ref, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = GetNextTradingDayYMD($record['date']);
        		if ($strClose = $ref->his_sql->GetClose($strDate))
        		{
       				_echoThanousLawItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref);
                }
            }
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoThanousLawParagraph($strSymbol, $iStart, $iNum)
{
	$ref = new LofReference($strSymbol);
	$est_ref = $ref->GetEstRef();
	$strEstSymbol = $est_ref->GetStockSymbol();

 	$str = GetFundLinks($strSymbol);

	$sql = new NetValueHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
	$str .= ' '.$strNavLink;

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium(),
								   new TableColumnMyStock($strEstSymbol),
								   new TableColumnChange()
								   ), THANOUS_LAW_PAGE, $str);

	_echoThanousLawData($sql, $ref->stock_ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoThanousLawPool($strSymbol, $strEstSymbol);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
            $fStart = microtime(true);
            _echoThanousLawParagraph($strSymbol, $acct->GetStart(), $acct->GetNum());
            DebugString($strSymbol.' Thanous Law: '.DebugGetStopWatchDisplay($fStart));
        }
    }
    $acct->EchoLinks(THANOUS_LAW_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().THANOUS_LAW_DISPLAY;
    $str .= '测试. 仅用于华宝油气(SZ162411)等LOF基金. 看白天A股华宝油气的溢价或者折价交易是否可以像小心愿认为的那样预测晚上美股XOP的涨跌.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().THANOUS_LAW_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart();

?>

