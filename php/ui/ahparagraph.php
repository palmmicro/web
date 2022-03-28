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
		
		$cny_ref = $ref->GetCnyRef();
		$ar[] = $ref->GetPriceDisplay($ref->EstFromPair(floatval($pair_ref->GetPrice()), $cny_ref->GetVal()));
    
		if ($fRatio = $ref->GetPriceRatio())
		{
			$ar[] = GetRatioDisplay($fRatio);
			$ar[] = GetRatioDisplay(1.0 / $fRatio);
		}
	}
    
    RefEchoTableColumn($ref, $ar);
}

function EchoAhParagraph($arRef)
{
	$str = GetAhCompareLink();
	$iCount = count($arRef);
	if ($iCount == 1)			$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbol());
	else if ($iCount > 2)		$arRef = RefSortByNumeric($arRef, '_callbackSortPair');

	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol(STOCK_DISP_HSHARES),
								   new TableColumnRMB(STOCK_DISP_HSHARES),
								   new TableColumnAhRatio(),
								   new TableColumnHaRatio()
								   ), 'ah', $str);

	foreach ($arRef as $ref)		_echoPairItem($ref);
    EchoTableParagraphEnd();
}

function EchoAdrhParagraph($arRef)
{
	$str = GetAdrhCompareLink();
	if (count($arRef) > 2)	$arRef = RefSortByNumeric($arRef, '_callbackSortPair');
	
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol(STOCK_DISP_HSHARES),
								   new TableColumnUSD(STOCK_DISP_HSHARES),
								   new TableColumnRatio('ADRH'),
								   new TableColumnRatio('HADR')
								   ), 'adrh', $str);
	
	foreach ($arRef as $ref)		_echoPairItem($ref);
    EchoTableParagraphEnd();
}

?>
