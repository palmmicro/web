<?php
require_once('smaparagraph.php');

function _callbackQdiiSma($qdii_ref, $strEst = false)
{
	return $strEst ? strval($qdii_ref->GetQdiiValue($strEst, $qdii_ref->strCNY)) : $qdii_ref->stock_ref;
}

function EchoQdiiSmaParagraph($qdii_ref, $callback2 = false)
{
	$ref = $qdii_ref->GetEstRef();
    if (RefHasData($ref) == false) 	return;
    
    EchoSmaParagraph($ref, false, $qdii_ref, '_callbackQdiiSma', $callback2);
}

?>
