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

function _callbackAhPairSma($ref, $strEst = false)
{
	return $strEst ? $ref->EstToPair($strEst) : $ref->GetPairRef();
}

function EchoAhPairSmaParagraph($ah_ref, $adr_ref)
{
	EchoSmaParagraph($ah_ref, false, $ah_ref, '_callbackAhPairSma');
	EchoFundPairSmaParagraph($ah_ref);
	if ($adr_ref)		EchoFundPairSmaParagraph($adr_ref, '');
}

?>
