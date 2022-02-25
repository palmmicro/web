<?php

function _getEtfPairExternalLink($sym)
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

function _echoEtfListItem($ref)
{
	$ar = array();
	
	$ar[] = GetCalibrationHistoryLink($ref->GetSymbol(), true);
    $ar[] = _getEtfPairExternalLink($ref->GetPairSym());
    $ar[] = GetNumberDisplay($ref->fRatio);
    $ar[] = GetNumberDisplay($ref->fFactor);
    RefEchoTableColumn($ref, $ar);
}

function EchoEtfListParagraph($arRef)
{
	$str = GetEtfListLink();
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnSymbol('跟踪'),
								   new TableColumn('杠杆倍数'),
								   new TableColumnCalibration()
								   ), ETF_LIST_PAGE, $str);
	
	foreach ($arRef as $ref)
	{
		_echoEtfListItem($ref);
	}
    EchoTableParagraphEnd();
}

?>
