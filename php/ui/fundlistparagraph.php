<?php

function _getFundPairExternalLink($sym)
{
	static $arSymbol = array();
	
	$strSymbol = $sym->GetSymbol();
	if (in_array($strSymbol, $arSymbol))		return $strSymbol;
	
	if ($sym->IsSinaFuture())
	{
		$strLink = GetSinaFutureLink($sym);
	}
	else if ($sym->IsSymbolUs())
	{
		$strLink = GetStockChartsLink($strSymbol);
	}
	else
	{
		$strLink = GetSinaStockLink($sym);
	}
	$arSymbol[] = $strSymbol;
	return $strLink;
}

function _echoFundListItem($ref)
{
	$ar = array();
	
	$ar[] = GetCalibrationHistoryLink($ref->GetSymbol(), true);
    $ar[] = _getFundPairExternalLink($ref->GetPairRef());
    $ar[] = GetNumberDisplay($ref->fRatio);
    $ar[] = GetNumberDisplay($ref->fFactor);
    RefEchoTableColumn($ref, $ar);
}

function EchoFundListParagraph($arRef)
{
	$str = GetFundListLink();
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol('跟踪'),
								   new TableColumn('杠杆倍数'),
								   new TableColumnCalibration()
								   ), 'fundlist', $str);
	
	foreach ($arRef as $ref)
	{
		_echoFundListItem($ref);
	}
    EchoTableParagraphEnd();
}

?>
