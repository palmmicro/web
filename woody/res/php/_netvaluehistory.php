<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoNetValueHistoryGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new DateImageFile();
    $ar = $csv->ReadColumn(1);
   	if (count($ar) > 0)
   	{
   		$jpg->DrawDateArray($ar);
   		$jpg->Show($strSymbol, '', $csv->GetLink());
   	}
}

function _echoNetValueItem($csv, $strNetValue, $strDate, $ref)
{
   	$csv->Write($strDate, $strNetValue);
   	
	$ar = array($strDate);
	if ($strClose = $ref->his_sql->GetClose($strDate))
	{
		$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
	}
	else
	{
		$ar[] = '';
	}

	$ar[] = $strNetValue;
	EchoTableColumn($ar);
}

function _echoNetValueData($sql, $ref, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
			_echoNetValueItem($csv, rtrim0($record['close']), $record['date'], $ref);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoNetValueHistory($ref, $iStart, $iNum)
{
	$strSymbol = $ref->GetStockSymbol();
    $str = GetFundHistoryLink($strSymbol);
    $str .= ' '.GetStockHistoryLink($strSymbol);
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetThanousLawLink($strSymbol);
    	$str .= ' '.GetFundAccountLink($strSymbol);
    }
    
	$sql = new NetValueHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
	$str .= ' '.$strNavLink;

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue()
								   ), 'netvalue', $str);

	_echoNetValueData($sql, $ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
    
    _echoNetValueHistoryGraph($strSymbol);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoNetValueHistory($ref, $iStart, $iNum);
    }
    $acct->EchoLinks('netvalue');
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().NETVALUE_HISTORY_DISPLAY;
    $str .= '页面. 用于某基金历史净值超过一定数量后的显示. 最近的基金净值记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等LOF基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().NETVALUE_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart();

?>

