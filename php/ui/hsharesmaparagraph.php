<?php
require_once('smaparagraph.php');

function _callbackHShareSmaA($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstFromCny($fEst);
	return $ref;
}

function _callbackHShareSmaH($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstToCny($fEst);
	return $ref->a_ref;
}

function _callbackHAdrSmaAdr($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstFromUsd($fEst);
	return $ref;
}

function _callbackHAdrSmaH($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstToUsd($fEst);
	return $ref->adr_ref;
}

function _callbackHAdrSmaUsd($ref, $fEst = false)
{
	if ($fEst)		return $ref->FromUsdToCny($fEst);
	return $ref->a_ref;
}

function _callbackHAdrSmaCny($ref, $fEst = false)
{
	if ($fEst)		return $ref->FromCnyToUsd($fEst);
	return $ref->adr_ref;
}

function EchoHShareSmaParagraph($ref, $hshare_ref, $bChinese)
{
    if ($ref->bHasData == false) 	return;
    
    $sym = $ref->GetSym();
	$callback = false;
	$str = false;
	if ($hshare_ref->a_ref && $hshare_ref->adr_ref)
	{
   		if ($sym->IsSymbolA())
   		{
   			$callback2 = _callbackHAdrSmaCny;
   			$callback = _callbackHShareSmaA;
   		}
   		else if ($sym->IsSymbolH())
   		{
   			$callback2 = _callbackHAdrSmaH;
   			$callback = _callbackHShareSmaH;
   		}
   		else
   		{
   			$callback2 = _callbackHAdrSmaUsd;
   			$callback = _callbackHAdrSmaAdr;
   		}
		EchoSmaParagraph($ref, $bChinese, false, $hshare_ref, $callback2);
		$str = '';
	}
	else if ($hshare_ref->a_ref)
	{
   		if ($sym->IsSymbolA())	$callback = _callbackHShareSmaA;
   		else				   			$callback = _callbackHShareSmaH;
	}
	else if ($hshare_ref->adr_ref)
	{
   		if ($sym->IsSymbolH())	$callback = _callbackHAdrSmaH;
   		else				   			$callback = _callbackHAdrSmaAdr;
	}
	
	EchoSmaParagraph($ref, $bChinese, $str, $hshare_ref, $callback);
}

?>
