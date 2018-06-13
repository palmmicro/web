<?php
require_once('smaparagraph.php');

function _callbackEtfSma($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstFromPair($fEst);
	return $ref;
}

function EchoEtfSmaParagraph($ref, $arEtfRef, $bChinese, $callback2 = false)
{
	foreach ($arEtfRef as $etf_ref)
	{
		EchoSmaParagraph($ref, $bChinese, '', $etf_ref, _callbackEtfSma, $callback2);
	}
}

?>
