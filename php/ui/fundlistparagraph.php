<?php

function _getFundPairLink($ref)
{
	static $arSymbol = array();
	
	$strSymbol = $ref->GetSymbol();
	if (in_array($strSymbol, $arSymbol))		return $strSymbol;
	
	$arSymbol[] = $strSymbol;
	return $ref->GetMyStockLink();
}

function _echoFundListItem($ref)
{
	$ar = array();
	
	$ar[] = GetCalibrationHistoryLink($ref->GetSymbol(), true);
    $ar[] = _getFundPairLink($ref->GetPairRef());
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
	
	foreach ($arRef as $ref)		_echoFundListItem($ref);
    EchoTableParagraphEnd();
}

?>
