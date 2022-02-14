<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/linearimagefile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousParadoxCsvFile extends PricePoolCsvFile
{
    public function OnLineArray($arWord)
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
    if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))
    {
    	$str = $csv->GetLink();
    	$str .= '<br />'.$jpg->GetAllLinks();
    	EchoParagraph($str);
    }
}

function _echoThanousParadoxItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref, $strEstStockId, $his_sql)
{
	$strEstClose = $his_sql->GetClose($strEstStockId, $strDate);
	$strEstClosePrev = $his_sql->GetClosePrev($strEstStockId, $strDate);
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

function _echoThanousParadoxData($csv, $nav_sql, $ref, $strStockId, $est_ref, $iStart, $iNum)
{
    if ($result = $nav_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
    	$his_sql = GetStockHistorySql();
    	$strEstStockId = $est_ref->GetStockId();
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = GetNextTradingDayYMD($record['date']);
        		if ($strClose = $his_sql->GetClose($strStockId, $strDate))
        		{
       				_echoThanousParadoxItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref, $strEstStockId, $his_sql);
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

 	$strStockId = $ref->GetStockId();
	$nav_sql = GetNavHistorySql();
   	$strMenuLink = StockGetMenuLink($strSymbol, $nav_sql->Count($strStockId), $iStart, $iNum);
	$str .= ' '.$strMenuLink;

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium('x'),
								   new TableColumnMyStock($strEstSymbol),
								   new TableColumnChange('y')
								   ), THANOUS_PARADOX_PAGE, $str);

   	$csv = new PageCsvFile();
	_echoThanousParadoxData($csv, $nav_sql, $ref->stock_ref, $strStockId, $est_ref, $iStart, $iNum);
    $csv->Close();
    EchoTableParagraphEnd($strMenuLink);

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

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(THANOUS_PARADOX_DISPLAY);
    $str .= '测试。观察白天A股QDII基金的溢价或者折价交易是否可以像小心愿认为的那样预测晚上美股相应ETF的涨跌。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(THANOUS_PARADOX_DISPLAY);
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

