<?php

function _ahStockRefCallbackData($ref, $bChinese)
{
	$ar = array();
	
    $strSymbolA = $ref->a_ref->GetStockSymbol();
    $ar[] = SelectAHCompareLink($strSymbolA, $bChinese);
    
    $fAHRatio = $ref->GetAhRatio();
    $ar[] = GetRatioDisplay($fAHRatio);
    $ar[] = GetRatioDisplay(1.0 / $fAHRatio);
	return $ar;
}

function _ahStockRefCallback($ref, $bChinese)
{
    if ($ref)
    {
        return _ahStockRefCallbackData($ref, $bChinese);
    }
    
    if ($bChinese)  $arColumn = array('A股代码', 'AH比价', 'HA比价');
    else              $arColumn = array('A Symbol', 'AH Ratio', 'HA Ratio');
    return $arColumn;
}

function EchoAhParagraph($arRef, $hkcny_ref, $bChinese)
{
    EchoParagraphBegin(GetAHCompareLink($bChinese).' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice);
    EchoStockRefTable($arRef, _ahStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

?>
