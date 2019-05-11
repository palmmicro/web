<?php
require_once('referenceparagraph.php');

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

function _etfListRefCallbackData($ref)
{
	$ar = array();
    $ar[] = _getEtfPairExternalLink($ref->GetPairSym());
    $ar[] = GetNumberDisplay($ref->fRatio);
    $strFactor = GetNumberDisplay($ref->fFactor);
    $ar[] = GetCalibrationLink($ref->GetStockSymbol(), $strFactor);
	return $ar;
}

function _etfListRefCallback($ref = false)
{
    if ($ref)
    {
        return _etfListRefCallbackData($ref);
    }
    
    return array('跟踪'.GetTableColumnSymbol(), '杠杆倍数', '校准值');
}

function EchoEtfListParagraph($arRef)
{
	$ar = array();
	foreach ($arRef as $ref)
	{
		$ar[$ref->GetStockSymbol()] = $ref->GetExternalLink();
		RefSetExternalLinkMyStock($ref);
	}
	$str = GetEtfListLink();
    EchoReferenceParagraph($arRef, '_etfListRefCallback', $str);
    
    // restore external link
    foreach ($arRef as $ref)
    {
    	$strSymbol = $ref->GetStockSymbol();
		if (array_key_exists($strSymbol, $ar))
		{
			$ref->SetExternalLink($ar[$strSymbol]);
		}
    }
}

?>
