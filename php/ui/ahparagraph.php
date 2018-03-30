<?php

function _ahStockRefCallbackData($ref, $bChinese)
{
	$ar = array();
	
    $hkcny_ref = new CNYReference('HKCNY');
    $strSymbolA = SqlGetHaPair($ref->GetStockSymbol());
    $ref_a = new MyStockReference($strSymbolA);
    $ar[] = SelectAHCompareLink($strSymbolA, $bChinese);
    
    $fAHRatio = $ref_a->fPrice / $hkcny_ref->fPrice / $ref->fPrice / AhGetRatio($strSymbolA);
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
	$arRef = array();
	foreach ($arSymbolH as $strSymbol)
	{
		$arRef[] = new MyStockReference($strSymbol);
	}
	
    $hkcny_ref = new CNYReference('HKCNY');
    EchoParagraphBegin(GetAHCompareLink($bChinese).' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice);
    EchoStockRefTable($arRef, _ahStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

?>
