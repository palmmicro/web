<?php
require_once('_stock.php');
require_once('/php/ui/calibrationparagraph.php');

function _echoCalibration($strSymbol, $strStockId, $iStart, $iNum, $bChinese)
{
    StockPrefetchData($strSymbol);
    
    $strSymbolLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese);
    EchoParagraph($strSymbolLink);
    EchoCalibrationParagraph($strSymbol, $strStockId, $bChinese, $iStart, $iNum);
}

function EchoCalibration($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		_echoCalibration($strSymbol, $strStockId, $iStart, $iNum, $bChinese);
    	}
    }
    EchoPromotionHead($bChinese, 'calibration');
}    

function EchoTitle($bChinese = true)
{
    EchoUrlSymbol();
    if ($bChinese)  echo '校准历史记录';
    else              echo ' Calibration History';
}

    AcctAuth();

?>

