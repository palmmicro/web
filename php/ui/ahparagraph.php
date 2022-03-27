<?php

function _echoAhItem($ref)
{
	$ar = array();
	
//   	$ar[] = RefGetMyStockLink($ref);
	$h_ref = $ref->GetPairRef();
   	$ar[] = RefGetMyStockLink($h_ref);
   	
//    $strSymbolA = $ref->GetSymbolA();
//    $ar[] = GetMyStockLink($strSymbolA);
   	$ar[] = RefGetMyStockLink($ref);
    
//    if ($fAhRatio = $ref->GetAhPriceRatio())
    if ($fAhRatio = $ref->GetPriceRatio())
    {
    	$ar[] = GetRatioDisplay($fAhRatio);
    	$ar[] = GetRatioDisplay(1.0 / $fAhRatio);
    }
    
//    RefEchoTableColumn($ref, $ar);
	RefEchoTableColumn($h_ref, $ar);
}

function _callbackSortAh($ref)
{
//	return $ref->GetAhPriceRatio();
	return $ref->GetPriceRatio();
}

function EchoAhParagraph($arRef)
{
	$str = GetAhCompareLink();
	$iCount = count($arRef);
	if ($iCount == 1)
	{
//		$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbolA());
		$str .= ' '.GetAhHistoryLink($arRef[0]->GetSymbol());
	}
	else if ($iCount > 2)
	{
		$arRef = RefSortByNumeric($arRef, '_callbackSortAh');
	}

	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol('A股'),
								   new TableColumnAhRatio(),
								   new TableColumnHaRatio()
								   ), 'ah', $str);

	foreach ($arRef as $ref)
	{
		_echoAhItem($ref);
	}
    EchoTableParagraphEnd();
}

function _echoAdrhItem($ref)
{
    if (RefHasData($ref) == false)      return;
    
	$ar = array();
	
   	$adr_ref = $ref->adr_ref;
    $ar[] = $adr_ref->GetStockLink();
   	$ar[] = $ref->GetMyStockLink();
   	
    $ar[] = $adr_ref->GetPriceDisplay($ref->GetUsdPrice());
    
    if ($fAdrhRatio = $ref->GetAdrhPriceRatio())
    {
    	$ar[] = GetRatioDisplay($fAdrhRatio);
    	$ar[] = GetRatioDisplay(1.0 / $fAdrhRatio);
    }
    
    RefEchoTableColumn($ref, $ar);
}

function _callbackSortAdrh($ref)
{
	return $ref->GetAdrhPriceRatio();
}

function EchoAdrhParagraph($arRef)
{
	$str = GetAdrhCompareLink();
	if (count($arRef) > 2)
	{
		$arRef = RefSortByNumeric($arRef, '_callbackSortAdrh');
	}

	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol(STOCK_DISP_HSHARES),
								   new TableColumnUSD(STOCK_DISP_HSHARES),
								   new TableColumnRatio('ADRH'),
								   new TableColumnRatio('HADR')
								   ), 'adrh', $str);

	foreach ($arRef as $ref)
	{
		_echoAdrhItem($ref);
	}
    EchoTableParagraphEnd();
}

?>
