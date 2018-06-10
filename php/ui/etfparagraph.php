<?php
require_once('referenceparagraph.php');

function _etfListRefCallbackData($ref, $bChinese)
{
	$ar = array();
    $ar[] = GetMyStockLink(SqlGetStockSymbol($ref->GetPairId()), $bChinese);
    $ar[] = GetNumberDisplay($ref->fRatio);
    $strFactor = GetNumberDisplay($ref->fFactor);
    $ar[] = GetStockSymbolLink('calibration', $ref->GetStockSymbol(), $bChinese, $strFactor);
	return $ar;
}

function _etfListRefCallback($bChinese, $ref = false)
{
    if ($ref)
    {
        return _etfListRefCallbackData($ref, $bChinese);
    }
    
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('跟踪'.$strSymbol, '杠杆倍数', '校准值');
    else              $arColumn = array('Follow '.$strSymbol, 'Ratio', 'Factor');
    return $arColumn;
}

function EchoEtfListParagraph($arRef, $bChinese)
{
	$str = GetEtfListLink($bChinese);
    EchoParagraphBegin($str);
    EchoReferenceTable($arRef, $bChinese, _etfListRefCallback);
    EchoParagraphEnd();
}

?>
