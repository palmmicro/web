<?php
require_once('smaparagraph.php');

function _callbackLofSma($lof_ref, $fEst = false)
{
	if ($fEst === false)
	{
		return $lof_ref->stock_ref;
	}
	return $lof_ref->GetLofValue($fEst, $lof_ref->fCNY);
}

function EchoLofSmaParagraph($lof_ref, $bChinese, $callback2 = false)
{
	$ref = $lof_ref->est_ref;
    if (StockRefHasData($ref) == false) 	return;
    
    EchoSmaParagraph($ref, $bChinese, false, $lof_ref, _callbackLofSma, $callback2);
}

?>
