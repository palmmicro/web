<?php
require_once('referenceparagraph.php');

function _getSortHLink($bChinese)
{
    return CopyPhpLink(UrlAddQuery('sort=hshare'), $bChinese, '按H股排序', 'Sort by H');
}

function _getSortRatioLink($bChinese)
{
	return CopyPhpLink(UrlAddQuery('sort=ratio'), $bChinese, '按比价排序', 'Sort by Ratio');
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
    $ar[] = RefGetDescription($ref->a_ref, $bChinese);
    $ar[] = GetRatioDisplay(1.0 / $ref->GetAhRatio());
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

function _refSortByRatio($arRef)
{
    $ar = array();
    $arRatio = array();
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetStockSymbol();
        $ar[$strSymbol] = $ref;
        $arRatio[$strSymbol] = $ref->GetAhRatio();
    }
    asort($arRatio, SORT_NUMERIC);
    
    $arSort = array();
    foreach ($arRatio as $strSymbol => $fRatio)
    {
        $arSort[] = $ar[$strSymbol];
    }
    return $arSort;
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
			if ($strSort == 'hshare')
			{
				$arRef = RefSortBySymbol($arRef);
			}
			else if ($strSort == 'ratio')
			{
				$arRef = _refSortByRatio($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink($bChinese);
			$str .= ' '._getSortRatioLink($bChinese);
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
/*    $ar[] = RefGetDescription($ref->adr_ref, $bChinese);
    $ar[] = GetRatioDisplay(1.0 / $ref->GetAdrhRatio());
*/    
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
/*	$arReference = GetReferenceTableColumn($bChinese);
	$strSymbol = $arReference[0];
	$strName = $arReference[5];
    if ($bChinese)  $arColumn = array('ADR'.$strSymbol, $strName, 'HADR比价');
    else              $arColumn = array('ADR '.$strSymbol, $strName, 'HADR Ratio');*/
    return $arColumn;
}

function EchoAdrhParagraph($arRef, $bChinese)
{
	$str = GetAdrhCompareLink($bChinese);
	if (count($arRef) > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'hshare')
			{
				$arRef = RefSortBySymbol($arRef);
			}
		}
		else
		{
			$str .= ' '._getSortHLink($bChinese);
		}
	}
    EchoReferenceParagraph($arRef, $bChinese, _adrhStockRefCallback, $str);
}

?>
