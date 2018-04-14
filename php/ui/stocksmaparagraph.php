<?php
require_once('smaparagraph.php');

function _callbackHShareSmaA($fEst, $ref)
{
	if ($fEst)		return $ref->EstFromCny($fEst);
	return $ref;
}

function _callbackHShareSmaH($fEst, $ref)
{
	if ($fEst)		return $ref->EstToCny($fEst);
	return $ref->a_ref;
}

function _callbackHAdrSmaAdr($fEst, $ref)
{
	if ($fEst)		return $ref->EstFromUsd($fEst);
	return $ref;
}

function _callbackHAdrSmaH($fEst, $ref)
{
	if ($fEst)		return $ref->EstToUsd($fEst);
	return $ref->adr_ref;
}

function _callbackHAdrSmaUsd($fEst, $ref)
{
	if ($fEst)		return $ref->FromUsdToCny($fEst);
	return $ref->a_ref;
}

function _callbackHAdrSmaCny($fEst, $ref)
{
	if ($fEst)		return $ref->FromCnyToUsd($fEst);
	return $ref->adr_ref;
}

function EchoStockSmaParagraph($ref, $hshare_ref, $hadr_ref, $bChinese)
{
    if ($ref->bHasData == false) 	return;
    
	$stock_his = new StockHistory($ref);
	$arColumn = EchoSmaParagraphBegin($stock_his, $bChinese);
	$callback = false;
	$cb_ref = false;
	if ($hshare_ref && $hadr_ref)
	{
		$cb_ref = $hadr_ref;
   		if ($ref->sym->IsSymbolA())
   		{
   			$callback2 = _callbackHAdrSmaCny;
   			$callback = _callbackHShareSmaA;
   		}
   		else if ($ref->sym->IsSymbolH())
   		{
   			$callback2 = _callbackHAdrSmaH;
   			$callback = _callbackHShareSmaH;
   		}
   		else
   		{
   			$callback2 = _callbackHAdrSmaUsd;
   			$callback = _callbackHAdrSmaAdr;
   		}
   		EchoSmaTable($arColumn, $stock_his, $hadr_ref, $callback2, false, $bChinese);
		EchoNewLine();
	}
	else if ($hshare_ref)
	{
		$cb_ref = $hshare_ref;
   		if ($ref->sym->IsSymbolA())	$callback = _callbackHShareSmaA;
   		else				   			$callback = _callbackHShareSmaH;
	}
	else if ($hadr_ref)
	{
		$cb_ref = $hadr_ref;
   		if ($ref->sym->IsSymbolH())	$callback = _callbackHAdrSmaH;
   		else				   			$callback = _callbackHAdrSmaAdr;
	}
	
	EchoSmaTable($arColumn, $stock_his, $cb_ref, $callback, false, $bChinese);
    EchoParagraphEnd();
}

?>
