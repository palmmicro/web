<?php
require_once('_stock.php');
require_once('/php/ui/calibrationparagraph.php');

function EchoCalibration($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);	
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
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

