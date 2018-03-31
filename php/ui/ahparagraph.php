<?php

$g_fHKDCNY = 0.0;

function _ahStockRefCallbackData($ref, $bChinese)
{
	global $g_fHKDCNY;
	$ar = array();
	
    $strSymbolA = SqlGetHaPair($ref->GetStockSymbol());
    $ref_a = new MyStockReference($strSymbolA);
    $ar[] = SelectAHCompareLink($strSymbolA, $bChinese);
    
    $fAHRatio = $ref_a->fPrice / $g_fHKDCNY / $ref->fPrice / SqlGetAhPairRatio($ref_a);
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

function EchoAhParagraph($arSymbolH, $bChinese)
{
	global $g_fHKDCNY;
    $hkcny_ref = new CNYReference('HKCNY');
    $g_fHKDCNY = $hkcny_ref->fPrice;
	
	$arRef = array();
    sort($arSymbolH);
	foreach ($arSymbolH as $strSymbol)
	{
		$arRef[] = new MyStockReference($strSymbol);
	}
	
    EchoParagraphBegin(GetAHCompareLink($bChinese).' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice);
    EchoStockRefTable($arRef, _ahStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

?>
