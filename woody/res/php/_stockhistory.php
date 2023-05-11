<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('../../php/ui/stockhistoryparagraph.php');

function _getStockHistoryLinks($ref, $bAdmin)
{
	$strSymbol = $ref->GetSymbol();
	
	$str = $ref->IsFund() ? GetFundLinks($strSymbol) : '';
    $str .= ' '.GetExternalStockHistoryLink($ref);
    if ($ref->IsTradable())	$str .= ' '.GetStockDividendLink($ref);
    if ($bAdmin)	$str .= ' '.StockGetAllLink($strSymbol).' '.GetUpdateStockHistoryLink($ref, '更新历史记录');
    return $str;
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strLinks = _getStockHistoryLinks($ref, $acct->IsAdmin());
   		$csv = new PageCsvFile();
   		EchoStockHistoryParagraph($ref, $strLinks, $csv, $acct->GetStart(), $acct->GetNum());
   		$csv->Close();
    }
    $acct->EchoLinks('stockhistory');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(STOCK_HISTORY_DISPLAY);
    $str .= '页面。用于查看计算SMA的原始数据，方便人工处理合股和拆股、分红除权等价格问题。附带简单的图形显示数据。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(STOCK_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();
?>
