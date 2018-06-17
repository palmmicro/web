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
    
    return CopyPhpLink($strQuery, $bChinese, '按H股排序', 'Sort by H');
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

function _ahStockRefCallback($bChinese, $ref = false)
{
    if ($ref)
    {
        return _ahStockRefCallbackData($ref, $bChinese);
    }
    return GetAhCompareTableColumn($bChinese);
}

function EchoAhParagraph($arRef, $bChinese)
{
	$str = GetAhCompareLink($bChinese);
	$iCount = count($arRef);
	if ($iCount == 1)
	{
		$str .= ' '.GetAhHistoryLink($arRef[0]->a_ref->GetStockSymbol(), $bChinese);
	}
	else if ($iCount > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'ha')
			{
				$arRef = RefSortBySymbol($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink('ha', $bChinese);
		}
	}
    EchoReferenceParagraph($arRef, $bChinese, _ahStockRefCallback, $str);
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

function _adrhStockRefCallback($bChinese, $ref = false)
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

function EchoAdrhParagraph($arRef, $bChinese)
{
	$str = GetAdrhCompareLink($bChinese);
	if (count($arRef) > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'hadr')
			{
				$arRef = RefSortBySymbol($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink('hadr', $bChinese);
		}
	}
    EchoReferenceParagraph($arRef, $bChinese, _adrhStockRefCallback, $str);
}

?>
