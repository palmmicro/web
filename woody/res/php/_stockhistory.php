<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');
require_once('/php/csvfile.php');
require_once('/php/ui/stockhistoryparagraph.php');

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);
   		
   		$sym = new StockSymbol($strSymbol);
        $ref = StockGetReference($sym);
        if ($ref->bHasData)
    	{
    		$csv = new PageCsvFile();
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
			EchoStockHistoryParagraph($ref, $bChinese, $csv, $iStart, $iNum);
    		if (AcctIsAdmin() && $iStart == 0)
    		{
				StockOptionEditForm($bChinese ? STOCK_OPTION_ADJCLOSE_CN : STOCK_OPTION_ADJCLOSE);
    		}
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '历史价格记录' : ' Historical Price');
}

    AcctAuth();

?>
