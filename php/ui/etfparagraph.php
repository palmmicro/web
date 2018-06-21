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

function _etfListRefCallbackData($ref, $bChinese)
{
	$ar = array();
    $ar[] = _getEtfPairExternalLink($ref->GetPairSym());
    $ar[] = GetNumberDisplay($ref->fRatio);
    $strFactor = GetNumberDisplay($ref->fFactor);
    $ar[] = GetStockSymbolLink('calibration', $ref->GetStockSymbol(), $bChinese, $strFactor);
	return $ar;
}

function _etfListRefCallback($bChinese, $ref = false)
{
    if ($ref)
    {
        return _etfListRefCallbackData($ref, $bChinese);
    }
    
	$strSymbol = GetReferenceTableSymbol($bChinese);
    if ($bChinese)  $arColumn = array('跟踪'.$strSymbol, '杠杆倍数', '校准值');
    else              $arColumn = array('Follow '.$strSymbol, 'Ratio', 'Factor');
    return $arColumn;
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
    EchoReferenceParagraph($arRef, $bChinese, _etfListRefCallback, $str);
    
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
