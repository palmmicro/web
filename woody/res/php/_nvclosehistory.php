<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/linearimagefile.php');
require_once('/php/ui/pricepoolparagraph.php');
require_once('/php/ui/nvclosehistoryparagraph.php');

class _NvCloseCsvFile extends PricePoolCsvFile
{
    public function OnLineArray($arWord)
    {
    	if (count($arWord) > 2)
    	{
    		$this->pool->OnData(floatval($arWord[1]), floatval($arWord[2]));
    	}
    }
}

function _echoNvClosePool($strSymbol)
{
   	$csv = new _NvCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol);
}

function _echoNvCloseGraph($csv)
{
    $jpg = new LinearImageFile();
    if ($jpg->Draw($csv->ReadColumn(1), $csv->ReadColumn(2)))
    {
    	$str = $csv->GetLink();
    	$str .= '<br />'.$jpg->GetAllLinks();
    	EchoParagraph($str);
    }
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetSymbol();
   		$strLinks = GetFundLinks($strSymbol);
   		$strLinks .= ' '.GetEtfNavLink($strSymbol);
   		if ($bAdmin = $acct->IsAdmin())	$strLinks .= '<br />'.StockGetAllLink($strSymbol).' '.GetOnClickLink(STOCK_PHP_PATH.'_submitspdrnav.php?symbol='.$strSymbol, "确认更新{$strSymbol}净值历史记录?", '更新净值');
    		
   		$csv = new PageCsvFile();
		EchoNvCloseHistoryParagraph($ref, $strLinks.'<br />', $csv, $acct->GetStart(), $acct->GetNum(), $bAdmin);
		$csv->Close();

		if ($csv->HasFile())
		{
			_echoNvClosePool($strSymbol);
			_echoNvCloseGraph($csv);
    	}
    }
    $acct->EchoLinks(NVCLOSE_HISTORY_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().NVCLOSE_HISTORY_DISPLAY;
    $str .= '页面. 观察ETF每天净值和收盘价偏离的情况. 同时判断偏离的方向和大小是否跟当天涨跌以及交易量相关, 总结规律以便提供可能的套利操作建议.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().NVCLOSE_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>
