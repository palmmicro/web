<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/linearimagefile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousParadoxCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	if (count($arWord) > 2)
    	{
    		$this->pool->OnData(floatval($arWord[2]), floatval($arWord[1]));
    	}
    }
}

function _echoThanousParadoxPool($strSymbol, $strTradingSymbol)
{
   	$csv = new _ThanousParadoxCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol, $strTradingSymbol, false);
}

function _echoThanousParadoxGraph($csv)
{
    $jpg = new LinearImageFile();
    $jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1));
	$str = $csv->GetLink();
	$str .= '<br />'.$jpg->GetAllLinks();
   	EchoParagraph($str);
}

function _echoThanousParadoxItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref)
{
	$his_sql = $est_ref->GetHistorySql();
	$strEstClose = $his_sql->GetClose($strDate);
	$strEstClosePrev = $his_sql->GetClosePrev($strDate);
	if (($strEstClose == false) || ($strEstClosePrev == false))		return;
	
   	$csv->Write($strDate, $est_ref->GetPercentageString($strEstClosePrev, $strEstClose), $ref->GetPercentageString($strNetValue, $strClose), $strNetValue);
   	
   	$ar = array($strDate);
   	$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
   	$ar[] = $strNetValue;
	$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $ar[] = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);
    $ar[] = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
	EchoTableColumn($ar);
}

function _echoThanousParadoxData($csv, $sql, $ref, $est_ref, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = GetNextTradingDayYMD($record['date']);
        		if ($strClose = $ref->his_sql->GetClose($strDate))
        		{
       				_echoThanousParadoxItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref);
                }
            }
        }
        @mysql_free_result($result);
    }
}

function _echoThanousParadoxParagraph($strSymbol, $iStart, $iNum)
{
	$ref = new QdiiReference($strSymbol);
	$est_ref = $ref->GetEstRef();
	$strEstSymbol = $est_ref->GetSymbol();

 	$str = GetFundLinks($strSymbol);

	$sql = new NetValueHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
	$str .= ' '.$strNavLink;

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium('x'),
								   new TableColumnMyStock($strEstSymbol),
								   new TableColumnChange('y')
								   ), THANOUS_PARADOX_PAGE, $str);

   	$csv = new PageCsvFile();
	_echoThanousParadoxData($csv, $sql, $ref->stock_ref, $est_ref, $iStart, $iNum);
    $csv->Close();
    EchoTableParagraphEnd($strNavLink);

	if ($csv->HasFile())
	{
		_echoThanousParadoxPool($strSymbol, $strEstSymbol);
		_echoThanousParadoxGraph($csv);
	}
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetSymbol();
        if (in_arrayQdii($strSymbol))
        {
//            $fStart = microtime(true);
            _echoThanousParadoxParagraph($strSymbol, $acct->GetStart(), $acct->GetNum());
//            DebugString($strSymbol.' Thanous Paradox: '.DebugGetStopWatchDisplay($fStart));
        }
    }
    $acct->EchoLinks(THANOUS_PARADOX_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().THANOUS_PARADOX_DISPLAY;
    $str .= '测试. 仅用于华宝油气(SZ162411)等QDII基金. 看白天A股华宝油气的溢价或者折价交易是否可以像小心愿认为的那样预测晚上美股XOP的涨跌.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().THANOUS_PARADOX_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

