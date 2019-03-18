<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');
require_once('/php/csvfile.php');
require_once('/php/ui/stockhistoryparagraph.php');

function _getStockHistoryLinks($ref, $bTest)
{
	$sym = $ref->GetSym();
    $strLinks = GetExternalStockHistoryLink($sym);
    if ($sym->IsTradable())
    {
    	$strLinks .= ' '.GetStockDividendLink($sym);
    }
    if ($bTest)
    {
    	$strLinks .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$ref->GetStockId(), '确认更新股票历史记录?', '更新历史记录');
    	$strLinks .= ' '.SqlCountTableDataString(TABLE_STOCK_HISTORY);
    }
    return $strLinks;
}

function EchoAll()
{
	$bTest = AcctIsAdmin();
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();
   		
   		$sym = new StockSymbol($strSymbol);
        $ref = StockGetReference($sym);
        if ($ref->HasData())
    	{
    		$strLinks = _getStockHistoryLinks($ref, $bTest);
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$csv = new PageCsvFile();
			EchoStockHistoryParagraph($ref, $strLinks, $csv, $iStart, $iNum);
			$csv->Close();

    		if ($bTest && $iStart == 0)
    		{
				StockOptionEditForm(STOCK_OPTION_ADJCLOSE);
    		}
    	}
    }
    EchoPromotionHead();
    EchoStockCategory();
}

function EchoMetaDescription()
{
    $str = UrlGetQueryDisplay('symbol');
    $str .= STOCK_HISTORY_DISPLAY.'页面. 用于查看计算SMA的原始数据, 提供跟Yahoo或者Sina历史数据同步的功能, 方便人工处理合股和拆股, 分红除权等价格处理问题.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo UrlGetQueryDisplay('symbol').STOCK_HISTORY_DISPLAY;
}

    AcctAuth();

?>
