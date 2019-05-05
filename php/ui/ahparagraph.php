<?php
require_once('referenceparagraph.php');

function _getSortHLink()
{
    return CopyPhpLink(UrlAddQuery('sort=hshare'), '按H股排序');
}

function _getSortRatioLink()
{
	return CopyPhpLink(UrlAddQuery('sort=ratio'), '按比价排序');
}

function _ahStockRefCallbackData($ref)
{
	$ar = array();
	
    $strSymbolA = $ref->a_ref->GetStockSymbol();
    $ar[] = GetMyStockLink($strSymbolA);
    $fAhRatio = $ref->GetAhRatio();
    $ar[] = GetRatioDisplay($fAhRatio);
    $ar[] = GetRatioDisplay(1.0 / $fAhRatio);
	return $ar;
}

function _ahStockRefCallback($ref = false)
{
    if ($ref)
    {
        return _ahStockRefCallbackData($ref);
    }
    return GetAhCompareTableColumn();
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

function EchoAhParagraph($arRef)
{
	$str = GetAhCompareLink();
	$iCount = count($arRef);
	if ($iCount == 1)
	{
		$str .= ' '.GetAhHistoryLink($arRef[0]->a_ref->GetStockSymbol());
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
			$str .= ' '._getSortHLink();
			$str .= ' '._getSortRatioLink();
		}
	}
    EchoReferenceParagraph($arRef, '_ahStockRefCallback', $str);
}

function _adrhStockRefCallbackData($ref)
{
	$ar = array();
	
    $strSymbolAdr = $ref->adr_ref->GetStockSymbol();
    $ar[] = GetMyStockLink($strSymbolAdr);
    $fAdrhRatio = $ref->GetAdrhRatio();
    $ar[] = GetRatioDisplay($fAdrhRatio);
    $ar[] = GetRatioDisplay(1.0 / $fAdrhRatio);
	return $ar;
}

function _adrhStockRefCallback($ref = false)
{
    if ($ref)
    {
        return _adrhStockRefCallbackData($ref);
    }
    
	$strSymbol = GetTableColumnSymbol();
    return array('ADR'.$strSymbol, 'ADRH比价', 'HADR比价');
}

function EchoAdrhParagraph($arRef)
{
	$str = GetAdrhCompareLink();
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
			$str .= ' '._getSortHLink();
		}
	}
    EchoReferenceParagraph($arRef, '_adrhStockRefCallback', $str);
}

?>
