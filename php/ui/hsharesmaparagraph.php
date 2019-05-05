<?php
require_once('smaparagraph.php');

function _callbackHShareSmaA($ref, $strEst = false)
{
	return $strEst ? $ref->EstFromCny($strEst) : $ref;
}

function _callbackHShareSmaH($ref, $strEst = false)
{
	return $strEst ? $ref->EstToCny($strEst) : $ref->a_ref;
}

function _callbackHAdrSmaAdr($ref, $strEst = false)
{
	return $strEst ? $ref->EstFromUsd($strEst) : $ref;
}

function _callbackHAdrSmaH($ref, $strEst = false)
{
	return $strEst ? $ref->EstToUsd($strEst) : $ref->adr_ref;
}

function _callbackHAdrSmaUsd($ref, $strEst = false)
{
	return $strEst ? $ref->FromUsdToCny($strEst) : $ref->a_ref;
}

function _callbackHAdrSmaCny($ref, $strEst = false)
{
	return $strEst ? $ref->FromCnyToUsd($strEst) : $ref->adr_ref;
}

function EchoHShareSmaParagraph($ref, $hshare_ref)
{
    if ($ref->HasData() == false) 	return;
    
    $sym = $ref->GetSym();
	$callback = false;
	$str = false;
	if ($hshare_ref->a_ref && $hshare_ref->adr_ref)
	{
   		if ($sym->IsSymbolA())
   		{
   			$callback2 = '_callbackHAdrSmaCny';
   			$callback = '_callbackHShareSmaA';
   		}
   		else if ($sym->IsSymbolH())
   		{
   			$callback2 = '_callbackHAdrSmaH';
   			$callback = '_callbackHShareSmaH';
   		}
   		else
   		{
   			$callback2 = '_callbackHAdrSmaUsd';
   			$callback = '_callbackHAdrSmaAdr';
   		}
		EchoSmaParagraph($ref, false, $hshare_ref, $callback2);
		$str = '';
	}
	else if ($hshare_ref->a_ref)
	{
   		if ($sym->IsSymbolA())	$callback = '_callbackHShareSmaA';
   		else				   		$callback = '_callbackHShareSmaH';
	}
	else if ($hshare_ref->adr_ref)
	{
   		if ($sym->IsSymbolH())	$callback = '_callbackHAdrSmaH';
   		else				   		$callback = '_callbackHAdrSmaAdr';
	}
	
	EchoSmaParagraph($ref, $str, $hshare_ref, $callback);
}

?>
