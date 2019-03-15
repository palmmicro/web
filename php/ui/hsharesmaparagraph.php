<?php
require_once('smaparagraph.php');

function _callbackHShareSmaA($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref;
	}
	return $ref->EstFromCny($fEst);
}

function _callbackHShareSmaH($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref->a_ref;
	}
	return $ref->EstToCny($fEst);
}

function _callbackHAdrSmaAdr($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref;
	}
	return $ref->EstFromUsd($fEst);
}

function _callbackHAdrSmaH($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref->adr_ref;
	}
	return $ref->EstToUsd($fEst);
}

function _callbackHAdrSmaUsd($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref->a_ref;
	}
	return $ref->FromUsdToCny($fEst);
}

function _callbackHAdrSmaCny($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref->adr_ref;
	}
	return $ref->FromCnyToUsd($fEst);
}

function EchoHShareSmaParagraph($ref, $hshare_ref, $bChinese = true)
{
    if ($ref->HasData() == false) 	return;
    
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
		EchoSmaParagraph($ref, false, $hshare_ref, $callback2);
		$str = '';
	}
	else if ($hshare_ref->a_ref)
	{
   		if ($sym->IsSymbolA())	$callback = _callbackHShareSmaA;
   		else				   		$callback = _callbackHShareSmaH;
	}
	else if ($hshare_ref->adr_ref)
	{
   		if ($sym->IsSymbolH())	$callback = _callbackHAdrSmaH;
   		else				   		$callback = _callbackHAdrSmaAdr;
	}
	
	EchoSmaParagraph($ref, $str, $hshare_ref, $callback);
}

?>
