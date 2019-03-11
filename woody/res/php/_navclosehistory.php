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

function _echoNavClosePool($strSymbol, $bChinese)
{
   	$csv = new _NavCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $bChinese, $strSymbol);
}

function _echoNavCloseGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2));
    $jpg->DrawCompareArray($csv->ReadColumn(3));
	$strPremium = $bChinese ? '溢价' : 'Premium';
    $jpg->Show($strPremium, $strSymbol, $csv->GetPathName());
}

function _getNavCloseHistoryLinks($ref, $bChinese)
{
	return GetStockHistoryLink($ref->GetStockSymbol(), $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);
   		
   		$sym = new StockSymbol($strSymbol);
        $ref = StockGetReference($sym);
        if ($ref->HasData())
    	{
    		$strLinks = _getNavCloseHistoryLinks($ref, $bChinese);
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$csv = new PageCsvFile();
			EchoNavCloseHistoryParagraph($ref, $bChinese, $strLinks, $csv, $iStart, $iNum);
			$csv->Close();

			_echoNavClosePool($strSymbol, $bChinese);
			_echoNavCloseGraph($strSymbol, $bChinese);
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoMetaDescription($bChinese = true)
{
    $str = UrlGetQueryDisplay('symbol');
    if ($bChinese)  $str .= '净值和收盘价历史比较页面. 观察每天净值和收盘价偏离的情况. 同时判断偏离的方向和大小是否跟当天涨跌以及交易量相关, 总结规律以便提供可能的套利操作建议.';
    else             $str .= ' NAV and close price compare page, check if the difference is related with daily change and quantity or not.';
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '净值和收盘价历史比较' : ' NAV Close History Compare');
}

    AcctAuth();

?>
