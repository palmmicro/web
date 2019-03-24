<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/pricepoolparagraph.php');
require_once('/php/ui/navclosehistoryparagraph.php');

class _NavCloseCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[1]), floatval($arWord[2]));
    }
}

function _echoNavClosePool($strSymbol)
{
   	$csv = new _NavCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol);
}

function _echoNavCloseGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2));
    $jpg->DrawCompareArray($csv->ReadColumn(3));
    $jpg->Show(STOCK_DISP_PREMIUM, $strSymbol, $csv->GetPathName());
}

function _getNavCloseHistoryLinks($ref)
{
	return GetStockHistoryLink($ref->GetStockSymbol());
}

function EchoAll()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();
   		
   		$sym = new StockSymbol($strSymbol);
        $ref = StockGetReference($sym);
        if ($ref->HasData())
    	{
    		$strLinks = _getNavCloseHistoryLinks($ref);
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$csv = new PageCsvFile();
			EchoNavCloseHistoryParagraph($ref, $strLinks, $csv, $iStart, $iNum);
			$csv->Close();

			_echoNavClosePool($strSymbol);
			_echoNavCloseGraph($strSymbol);
    	}
    }
    EchoPromotionHead();
    EchoStockCategory();
}

function EchoMetaDescription()
{
    $str = UrlGetQueryDisplay('symbol');
    $str .= '净值和收盘价历史比较页面. 观察每天净值和收盘价偏离的情况. 同时判断偏离的方向和大小是否跟当天涨跌以及交易量相关, 总结规律以便提供可能的套利操作建议.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo UrlGetQueryDisplay('symbol').NAVCLOSE_HISTORY_DISPLAY;
}

    AcctAuth();

?>
