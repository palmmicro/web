<?php
require_once('referenceparagraph.php');

function _etfListRefCallbackData($ref, $bChinese)
{
	$ar = array();
    $ar[] = GetMyStockLink(SqlGetStockSymbol($ref->strPairId), $bChinese);
    $ar[] = GetRatioDisplay($ref->fRatio);
    $ar[] = GetRatioDisplay($ref->fFactor);
	return $ar;
}

function _etfListRefCallback($ref, $bChinese)
{
    if ($ref)
    {
        return _etfListRefCallbackData($ref, $bChinese);
    }
    
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('指数'.$strSymbol, '杠杆倍数', '校准值');
    else              $arColumn = array('Index '.$strSymbol, 'Ratio', 'Factor');
    return $arColumn;
}

function EchoEtfListParagraph($arRef, $bChinese)
{
	$str = GetEtfListLink($bChinese);
    EchoParagraphBegin($str);
    EchoStockRefTable($arRef, _etfListRefCallback, $bChinese);
    EchoParagraphEnd();
}

?>
