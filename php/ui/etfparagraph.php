<?php
require_once('referenceparagraph.php');

function _getEtfPairExternalLink($sym)
{
	static $arSymbol = array();
	
	$strSymbol = $sym->GetSymbol();
	if (in_array($strSymbol, $arSymbol))		return $strSymbol;
	
	if ($strFutureSymbol = $sym->IsSinaFuture())
	{
		$strLink = GetSinaFutureLink($strFutureSymbol);
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
    $ar[] = GetStockSymbolLink('calibration', $ref->GetStockSymbol(), $strFactor);
	return $ar;
}

function _etfListRefCallback($ref = false)
{
    if ($ref)
    {
        return _etfListRefCallbackData($ref);
    }
    
	$strSymbol = GetReferenceTableSymbol();
    return array('跟踪'.$strSymbol, '杠杆倍数', '校准值');
}

function EchoEtfListParagraph($arRef, $bChinese)
{
	$ar = array();
	foreach ($arRef as $ref)
	{
		$sym = $ref->GetSym();
		if ($strDigit = $sym->IsFundA())
		{
			$ar[$strDigit] = $ref->GetExternalLink();
			$ref->SetExternalLink(GetEastMoneyFundRatioLink($sym));
		}
	}
	$str = GetEtfListLink($bChinese);
    EchoReferenceParagraph($arRef, _etfListRefCallback, $str);
    
    // restore external link
    foreach ($arRef as $ref)
    {
		$sym = $ref->GetSym();
		if ($strDigit = $sym->IsFundA())
		{
			if (array_key_exists($strDigit, $ar))
			{
				$ref->SetExternalLink($ar[$strDigit]);
			}
		}
    }
}

?>
