<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/pricepoolparagraph.php');
require_once('/php/ui/nvclosehistoryparagraph.php');

class _NvCloseCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[1]), floatval($arWord[2]));
    }
}

function _echoNvClosePool($strSymbol)
{
   	$csv = new _NvCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol);
}

function _echoNvCloseGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2));
    $jpg->DrawCompareArray($csv->ReadColumn(3));
    $jpg->Show(STOCK_DISP_PREMIUM, $strSymbol, $csv->GetLink());
}

function EchoAll()
{
	global $group;
	
    if ($ref = $group->EchoStockGroup())
    {
        if ($ref->HasData())
    	{
    		$strSymbol = $ref->GetStockSymbol();
    		$strLinks = GetStockHistoryLink($strSymbol);
    		if ($group->IsAdmin())
    		{
    			$strLinks .= ' '.GetPhpLink(STOCK_PATH.'spdrnavxls', false, '更新净值');
    		}
    		
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		$csv = new PageCsvFile();
			EchoNvCloseHistoryParagraph($ref, $strLinks, $csv, $iStart, $iNum);
			$csv->Close();

			if ($csv->HasFile())
			{
				_echoNvClosePool($strSymbol);
				_echoNvCloseGraph($strSymbol);
			}
    	}
    }
    $group->EchoLinks('nvclose');
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().NVCLOSE_HISTORY_DISPLAY;
    $str .= '页面. 观察每天净值和收盘价偏离的情况. 同时判断偏离的方向和大小是否跟当天涨跌以及交易量相关, 总结规律以便提供可能的套利操作建议.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().NVCLOSE_HISTORY_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage();

?>
