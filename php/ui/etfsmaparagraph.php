<?php
require_once('smaparagraph.php');

function _callbackEtfSma($ref, $fEst = false)
{
	if ($fEst)		return $ref->EstFromPair($fEst);
	return $ref;
}

function EchoEtfSmaParagraph($stock_his, $arRef, $bChinese, $callback2 = false)
{
    if ($stock_his == false)              return;
    
	$arColumn = EchoSmaParagraphBegin($stock_his, $bChinese);
	foreach ($arRef as $ref)
	{
		EchoSmaTable($arColumn, $stock_his, $bChinese, $ref, _callbackEtfSma, $callback2);
		EchoNewLine();
	}
    EchoParagraphEnd();
}

?>
