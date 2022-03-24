<?php
require_once('smaparagraph.php');

function _callbackFundPairSma($ref, $strEst = false)
{
	return $strEst ? $ref->EstFromPair($strEst) : $ref;
}

function EchoFundPairSmaParagraphs($ref, $arFundPairRef, $callback2 = false)
{
	foreach ($arFundPairRef as $fund_pair_ref)
	{
		EchoSmaParagraph($ref, '', $fund_pair_ref, '_callbackFundPairSma', $callback2);
	}
}

function EchoFundPairSmaParagraph($ref, $str = false, $callback2 = false)
{
	EchoSmaParagraph($ref->GetPairRef(), $str, $ref, '_callbackFundPairSma', $callback2);
}

?>
