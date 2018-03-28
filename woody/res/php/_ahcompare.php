<?php
require_once('_stock.php');
require_once('/php/ui/ahparagraph.php');

function _EchoCompareAH($bChinese)
{
    $ar = AhGetArray();
    $arPrefetch = array();
    foreach ($ar as $strSymbolA => $strSymbolH)
    {
        $arPrefetch[] = $strSymbolA;
    }
    PrefetchStockData($arPrefetch);
    
    $arRefH = array();
    foreach ($arPrefetch as $strSymbol)
    {
    	$ref = new MyStockReference($strSymbol);
        $ref->h_ref->h_ref = $ref;
        $arRefH[] = $ref->h_ref;
    }
    EchoAhParagraph($arRefH, $bChinese);
    
    EchoPromotionHead('', $bChinese);
}

    AcctNoAuth();

?>

