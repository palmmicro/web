<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');
require_once('/php/csvfile.php');
require_once('/php/ui/stockhistoryparagraph.php');

function _getStockHistoryLinks($ref, $bTest, $bChinese)
{
	$sym = $ref->GetSym();
    $strLinks = GetStockHistoryLink($sym, $bChinese);
    if ($sym->IsTradable())			$strLinks .= ' '.GetStockDividendLink($sym, $bChinese);
    if ($bTest)
    {
    	$strLinks .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$ref->GetStockId(), $bChinese ? '确认更新股票历史记录?' : 'Confirm update stock history?', $bChinese ? '更新历史记录' : 'Update History');
    	$strLinks .= ' '.SqlCountTableDataString(TABLE_STOCK_HISTORY);
    }
    return $strLinks;
}

function EchoAll($bChinese = true)
{
	$bTest = AcctIsAdmin();
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);
   		
   		$sym = new StockSymbol($strSymbol);
        $ref = StockGetReference($sym);
        if ($ref->HasData())
    	{
    		$strLinks = _getStockHistoryLinks($ref, $bTest, $bChinese);
    		$csv = new PageCsvFile();
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
			EchoStockHistoryParagraph($ref, $bChinese, $strLinks, $csv, $iStart, $iNum);
    		if ($bTest && $iStart == 0)
    		{
				StockOptionEditForm($bChinese ? STOCK_OPTION_ADJCLOSE_CN : STOCK_OPTION_ADJCLOSE);
    		}
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoMetaDescription($bChinese = true)
{
    $str = UrlGetQueryDisplay('symbol');
    if ($bChinese)  $str .= '历史价格记录页面. 用于查看计算SMA的原始数据, 提供跟Yahoo历史数据同步的功能, 方便人工处理合股和拆股, 分红除权等价格处理问题.';
    else             $str .= ' stock history page. View the data to calculate SMA here, with functions to get Yahoo stock history data.';
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '历史价格记录' : ' Historical Price');
}

function EchoHeadLine($bChinese = true)
{
	EchoTitle($bChinese);
}

    AcctAuth();

?>
