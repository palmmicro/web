<?php
require_once('referenceparagraph.php');

function GetSortString($strQuery)
{
    $ar = array('hshare' => '按H股排序',
                  'ratio' => '按比价排序',
                 );
	return $ar[$strQuery];
}

function _getSortLink($strQuery = 'hshare')
{
    return CopyPhpLink(UrlAddQuery('sort='.$strQuery), GetSortString($strQuery));
}

function _ahStockRefCallbackData($ref)
{
	$ar = array();
	
    $strSymbolA = $ref->GetSymbolA();
    $ar[] = GetMyStockLink($strSymbolA);
    $fAhRatio = $ref->GetAhPriceRatio();
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

function _refSortByRatio($arRef, $bAh = true)
{
    $ar = array();
    $arRatio = array();
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetStockSymbol();
        $ar[$strSymbol] = $ref;
        $arRatio[$strSymbol] = ($bAh ? $ref->GetAhPriceRatio() : $ref->GetAdrhPriceRatio()); 
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
		$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbolA());
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
			$str .= ' '._getSortLink();
			$str .= ' '._getSortLink('ratio');
		}
	}
    EchoReferenceParagraph($arRef, '_ahStockRefCallback', $str);
}

function _adrhStockRefCallbackData($ref)
{
	$ar = array();
	
    $strSymbolAdr = $ref->adr_ref->GetStockSymbol();
    $ar[] = GetMyStockLink($strSymbolAdr);
    $fAdrhRatio = $ref->GetAdrhPriceRatio();
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
			else if ($strSort == 'ratio')
			{
				$arRef = _refSortByRatio($arRef, false);
			}
		}
		else
		{
			$str .= ' '._getSortLink();
		}
	}
    EchoReferenceParagraph($arRef, '_adrhStockRefCallback', $str);
}

?>
