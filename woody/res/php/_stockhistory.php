<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_editstockoptionform.php');
require_once('/php/csvfile.php');
require_once('/php/ui/stockhistoryparagraph.php');

function _getStockHistoryLinks($ref, $bAdmin)
{
	$sym = $ref->GetSym();
    $strLinks = GetExternalStockHistoryLink($sym);
    if ($sym->IsTradable())
    {
    	$strLinks .= ' '.GetStockDividendLink($sym);
    }
    if ($bAdmin)
    {
    	$strLinks .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$ref->GetStockId(), '确认更新股票历史记录?', '更新历史记录');
    	$strLinks .= ' '.SqlCountTableDataString(TABLE_STOCK_HISTORY);
    }
    return $strLinks;
}

function EchoAll()
{
	global $group;
	
	$bAdmin = $group->IsAdmin();
	$ref = $group->GetRef();
    if (RefHasData($ref))
    {
   		EchoStockGroupParagraph();

   		$strLinks = _getStockHistoryLinks($ref, $bAdmin);
    	$iStart = UrlGetQueryInt('start');
    	$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    	$csv = new PageCsvFile();
		EchoStockHistoryParagraph($ref, $strLinks, $csv, $iStart, $iNum);
		$csv->Close();

    	if ($bAdmin && $iStart == 0)
    	{
			StockOptionEditForm($ref, STOCK_OPTION_ADJCLOSE);
    	}
    }
    $group->EchoLinks();
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().STOCK_HISTORY_DISPLAY;
    $str .= '页面. 用于查看计算SMA的原始数据, 提供跟Yahoo或者Sina历史数据同步的功能, 方便人工处理合股和拆股, 分红除权等价格处理问题.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().STOCK_HISTORY_DISPLAY;
  	echo $str;
}

    $strMemberId = AcctAuth();
    $group = new StockSymbolPage($strMemberId);

?>
