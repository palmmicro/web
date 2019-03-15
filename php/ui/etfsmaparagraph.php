<?php
require_once('smaparagraph.php');

function _callbackEtfSma($ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $ref;
	}
	return $ref->EstFromPair($fEst);
}

function EchoEtfArraySmaParagraph($ref, $arEtfRef, $callback2 = false)
{
	foreach ($arEtfRef as $etf_ref)
	{
		EchoSmaParagraph($ref, '', $etf_ref, _callbackEtfSma, $callback2);
	}
}

function EchoEtfSmaParagraph($ref, $str = false, $callback2 = false)
{
	EchoSmaParagraph($ref->pair_ref, $str, $ref, _callbackEtfSma, $callback2);
}

?>
