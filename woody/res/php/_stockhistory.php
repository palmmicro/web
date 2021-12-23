<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/stockhistoryparagraph.php');

function _getStockHistoryLinks($ref, $bAdmin)
{
	$strSymbol = $ref->GetSymbol();
	
	$strLinks = '';
    if ($ref->IsFundA())
    {
    	$strLinks .= ' '.GetFundLinks($strSymbol);
    }
    $strLinks .= ' '.GetExternalStockHistoryLink($ref);
    if ($ref->IsTradable())
    {
    	$strLinks .= ' '.GetStockDividendLink($ref);
    }
    if ($bAdmin)
    {
    	$strLinks .= ' '.GetUpdateStockHistoryLink($strSymbol, '更新历史记录');
    }
    return $strLinks;
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	if ($ref->HasData())
    	{
    		$strLinks = _getStockHistoryLinks($ref, $acct->IsAdmin());
    		$csv = new PageCsvFile();
    		EchoStockHistoryParagraph($ref, $strLinks, $csv, $acct->GetStart(), $acct->GetNum());
    		$csv->Close();
    	}
    }
    $acct->EchoLinks(TABLE_STOCK_HISTORY);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().STOCK_HISTORY_DISPLAY;
    $str .= '页面. 用于查看计算SMA的原始数据, 提供跟Yahoo或者Sina历史数据同步的功能, 方便人工处理合股和拆股, 分红除权等价格问题. 附带简单的图形显示数据.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().STOCK_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>
