<?php
require_once('_stock.php');
require_once('/php/ui/calibrationparagraph.php');

function EchoCalibration($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		StockPrefetchData($strSymbol);
    		
    		$strSymbolLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese);
    		EchoParagraph($strSymbolLink);
    
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		EchoCalibrationParagraph($strSymbol, $bChinese, $iStart, $iNum);
    	}
    }
    EchoPromotionHead($bChinese, 'calibration');
}    

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '校准历史记录' : ' Calibration History');
}

    AcctAuth();

?>

