<?php
require_once('referenceparagraph.php');

function _getSortHLink($strSort, $bChinese)
{
    $strSortQuery = 'sort='.$strSort;
    if ($strQuery = UrlGetQueryString())
    {
    	$strQuery .= '&'.$strSortQuery;
    }
    else
    {
    	$strQuery = $strSortQuery;
    }
    
    return UrlBuildPhpLink(UrlGetUriTitle(), $strQuery, '按H股排序', 'Sort by H', $bChinese);
}

function _selectAhCompareLink($strSymbol, $bChinese)
{
    if ($strSymbol == UrlGetQueryValue('symbol'))
    {   // in mystock.php
        return GetJisiluAhLink($strSymbol);
    }
    return GetMyStockLink($strSymbol, $bChinese);
}

function _ahStockRefCallbackData($ref, $bChinese)
{
	$ar = array();
	
    $strSymbolA = $ref->a_ref->GetStockSymbol();
    $ar[] = _selectAhCompareLink($strSymbolA, $bChinese);
    
    $fAhRatio = $ref->GetAhRatio();
    $ar[] = GetRatioDisplay($fAhRatio);
    $ar[] = GetRatioDisplay(1.0 / $fAhRatio);
	return $ar;
}

function _ahStockRefCallback($ref, $bChinese)
{
    if ($ref)
    {
        return _ahStockRefCallbackData($ref, $bChinese);
    }
    
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('A股'.$strSymbol, 'AH比价', 'HA比价');
    else              $arColumn = array('A '.$strSymbol, 'AH Ratio', 'HA Ratio');
    return $arColumn;
}

function EchoAhParagraph($arRef, $hkcny_ref, $bChinese)
{
	$str = GetAhCompareLink($bChinese).' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice;
	if (count($arRef) > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'ha')
			{
				$arRef = StockReferenceSortBySymbol($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink('ha', $bChinese);
		}
	}
    EchoParagraphBegin($str);
    EchoStockRefTable($arRef, _ahStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

function _selectAdrhCompareLink($strSymbol, $bChinese)
{
    if ($strSymbol == UrlGetQueryValue('symbol'))
    {   // in mystock.php
        return GetAdrLink($strSymbol);
    }
    return GetMyStockLink($strSymbol, $bChinese);
}

function _adrhStockRefCallbackData($ref, $bChinese)
{
	$ar = array();
	
    $strSymbolAdr = $ref->adr_ref->GetStockSymbol();
    $ar[] = _selectAdrhCompareLink($strSymbolAdr, $bChinese);
    
    $fAdrhRatio = $ref->GetAdrhRatio();
    $ar[] = GetRatioDisplay($fAdrhRatio);
    $ar[] = GetRatioDisplay(1.0 / $fAdrhRatio);
	return $ar;
}

function _adrhStockRefCallback($ref, $bChinese)
{
    if ($ref)
    {
        return _adrhStockRefCallbackData($ref, $bChinese);
    }
    
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('ADR'.$strSymbol, 'ADRH比价', 'HADR比价');
    else              $arColumn = array('ADR '.$strSymbol, 'ADRH Ratio', 'HADR Ratio');
    return $arColumn;
}

function EchoAdrhParagraph($arRef, $uscny_ref, $hkcny_ref, $bChinese)
{
	$str = GetAdrhCompareLink($bChinese).' '.$uscny_ref->strDescription.' '.$uscny_ref->strPrice.' '.$hkcny_ref->strDescription.' '.$hkcny_ref->strPrice;
	if (count($arRef) > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'hadr')
			{
				$arRef = StockReferenceSortBySymbol($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink('hadr', $bChinese);
		}
	}
    EchoParagraphBegin($str);
    EchoStockRefTable($arRef, _adrhStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

?>
