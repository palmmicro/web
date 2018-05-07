<?php
require_once('_stock.php');
require_once('/php/ui/calibrationparagraph.php');

function _echoCalibration($strSymbol, $iStart, $iNum, $bChinese)
{
    if (($strStockId = SqlGetStockId($strSymbol)) == false)  return;
    
    $strSymbolLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese);
    $sql = new SqlEtfCalibration($strStockId);
    $iTotal = $sql->Count();
    $strNavLink = _GetStockNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    EchoParagraph($strSymbolLink.$strNavLink);
    EchoCalibrationFullParagraph($strSymbol, $iStart, $iNum, $bChinese);
}

function EchoCalibration($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
        $iStart = UrlGetQueryInt('start', 0);
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        _echoCalibration($strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead('calibration', $bChinese);
}    

function EchoTitle($bChinese)
{
    EchoUrlSymbol();
    if ($bChinese)  echo '校准历史记录';
    else              echo ' Calibration History';
}

    AcctAuth();

?>

