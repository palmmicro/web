<?php
require_once('_stock.php');

function _EchoCompareAH($bChinese)
{
    $ar = AhGetArray();
    $arPrefetch = array();
    foreach ($ar as $strSymbolA => $strSymbolH)
    {
        $arPrefetch[] = $strSymbolA;
    }
    PrefetchStockData($arPrefetch);
    
    $arRefAH = array();
    foreach ($arPrefetch as $strSymbol)
    {
        $arRefAH[] = new MyStockReference($strSymbol);
    }
    EchoAHStockParagraph($arRefAH, $bChinese);
    
    EchoPromotionHead('', $bChinese);
}

    AcctNoAuth();

?>

