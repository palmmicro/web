<?php

function _callbackSortPair($ref)
{
	return $ref->GetPriceRatio();
}

function _echoPairItem($ref, $bWide)
{
	$ar = array($ref->GetMyStockLink());
	
	if ($bWide)		$ar = array_merge($ar, GetStockReferenceArray($ref));
	if ($pair_ref = $ref->GetPairRef())
	{
		$ar[] = $pair_ref->GetMyStockLink();
		$ar[] = $pair_ref->GetPriceDisplay();
		
		$cny_ref = $ref->GetCnyRef();
		$ar[] = $ref->GetPriceDisplay(strval($ref->EstFromPair(floatval($pair_ref->GetPrice()), $cny_ref->GetVal())));
    
		if ($fRatio = $ref->GetPriceRatio())
		{
			$ar[] = GetRatioDisplay($fRatio);
			$ar[] = GetRatioDisplay(1.0 / $fRatio);
		}
	}
    
    RefEchoTableColumn($ref, $ar, $bWide);
}

function _echoPairParagraph($ar, $strId, $str, $arRef, $bWide)
{
	EchoTableParagraphBegin($ar, $strId, $str);
	if (count($arRef) > 2)	$arRef = RefSortByNumeric($arRef, '_callbackSortPair');
	foreach ($arRef as $ref)		_echoPairItem($ref, $bWide);
    EchoTableParagraphEnd();
}

function _getPairColumn($bWide)
{
	$ar = array(new TableColumnSymbol());
	if ($bWide)	$ar = array_merge($ar, GetStockReferenceColumn());
	return $ar;
}

function EchoAbParagraph($arRef, $bWide = false)
{
	$str = GetAbCompareLink();
	$ar = array_merge(_getPairColumn($bWide), 
			array(new TableColumnSymbol(STOCK_DISP_BSHARES),
			      new TableColumnPrice(STOCK_DISP_BSHARES),
				  new TableColumnRMB(STOCK_DISP_BSHARES),
				  new TableColumnRatio('A/B'),
				  new TableColumnRatio('B/A')));
	_echoPairParagraph($ar, 'ab', $str, $arRef, $bWide);
}

function EchoAhParagraph($arRef, $bWide = false)
{
	$str = GetAhCompareLink();
	if (count($arRef) == 1)	$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbol());
	$ar = array_merge(_getPairColumn($bWide), 
			array(new TableColumnSymbol(STOCK_DISP_HSHARES),
			     new TableColumnPrice(STOCK_DISP_HSHARES),
				 new TableColumnRMB(STOCK_DISP_HSHARES),
				 new TableColumnRatio('A/H'),
				 new TableColumnRatio('H/A')));
	_echoPairParagraph($ar, 'ah', $str, $arRef, $bWide);
}

function EchoAdrhParagraph($arRef, $bWide = false)
{
	$str = GetAdrhCompareLink();
	$ar = array_merge(_getPairColumn($bWide), 
			array(new TableColumnSymbol(STOCK_DISP_HSHARES),
			     new TableColumnPrice(STOCK_DISP_HSHARES),
				 new TableColumnUSD(STOCK_DISP_HSHARES),
				 new TableColumnRatio('ADR/H'),
				 new TableColumnRatio('H/ADR')));
	_echoPairParagraph($ar, 'adr', $str, $arRef, $bWide);
}

?>
