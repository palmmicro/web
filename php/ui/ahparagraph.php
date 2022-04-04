<?php

function _callbackSortPair($ref)
{
	return $ref->GetPriceRatio();
}

function _echoPairItem($ref)
{
	$ar = array();
	
	$ar[] = $ref->GetMyStockLink();
	if ($pair_ref = $ref->GetPairRef())
	{
		$ar[] = $pair_ref->GetMyStockLink();
		$ar[] = $ref->GetPriceDisplay();
		
		$cny_ref = $ref->GetCnyRef();
		$ar[] = $ref->GetPriceDisplay(strval($ref->EstFromPair(floatval($pair_ref->GetPrice()), $cny_ref->GetVal())));
    
		if ($fRatio = $ref->GetPriceRatio())
		{
			$ar[] = GetRatioDisplay($fRatio);
			$ar[] = GetRatioDisplay(1.0 / $fRatio);
		}
	}
    
    RefEchoTableColumn($ref, $ar);
}

function _echoPairParagraph($ar, $strId, $str, $arRef)
{
	EchoTableParagraphBegin($ar, $strId, $str);
	if (count($arRef) > 2)	$arRef = RefSortByNumeric($arRef, '_callbackSortPair');
	foreach ($arRef as $ref)		_echoPairItem($ref);
    EchoTableParagraphEnd();
}

function EchoAbParagraph($arRef)
{
	$str = GetAbCompareLink();
	$ar = array(new TableColumnSymbol(),
			      new TableColumnSymbol(STOCK_DISP_BSHARES),
			      new TableColumnPrice(STOCK_DISP_ASHARES),
				  new TableColumnRMB(STOCK_DISP_BSHARES),
				  new TableColumnRatio('A/B'),
				  new TableColumnRatio('B/A'));
	_echoPairParagraph($ar, 'ab', $str, $arRef);
}

function EchoAhParagraph($arRef)
{
	$str = GetAhCompareLink();
	if (count($arRef) == 1)	$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbol());
	$ar = array(new TableColumnSymbol(),
				 new TableColumnSymbol(STOCK_DISP_HSHARES),
			     new TableColumnPrice(STOCK_DISP_ASHARES),
				 new TableColumnRMB(STOCK_DISP_HSHARES),
				 new TableColumnRatio('A/H'),
				 new TableColumnRatio('H/A'));
	_echoPairParagraph($ar, 'ah', $str, $arRef);
}

function EchoAdrhParagraph($arRef)
{
	$str = GetAdrhCompareLink();
	$ar = array(new TableColumnSymbol(),
			     new TableColumnSymbol(STOCK_DISP_HSHARES),
			     new TableColumnPrice('ADR'),
				 new TableColumnUSD(STOCK_DISP_HSHARES),
				 new TableColumnRatio('ADR/H'),
				 new TableColumnRatio('H/ADR'));
	_echoPairParagraph($ar, 'adr', $str, $arRef);
}

?>
