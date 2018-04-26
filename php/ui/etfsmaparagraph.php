<?php
require_once('smaparagraph.php');

function _callbackEtfSma($fEst, $ref)
{
	if ($fEst)		return $ref->EstFromPair($fEst);
	return $ref;
}

function EchoEtfSmaParagraph($stock_his, $arRef, $callback2, $bChinese)
{
    if ($stock_his == false)              return;
    
	$arColumn = EchoSmaParagraphBegin($stock_his, $bChinese);
	foreach ($arRef as $ref)
	{
		EchoSmaTable($arColumn, $stock_his, $ref, _callbackEtfSma, $callback2, $bChinese);
		EchoNewLine();
	}
    EchoParagraphEnd();
}

?>
