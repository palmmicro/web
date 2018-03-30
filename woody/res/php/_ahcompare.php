<?php
require_once('_stock.php');
require_once('/php/ui/ahparagraph.php');

function _EchoCompareAH($bChinese)
{
    $arPrefetch = array();
    $arSymbolH = array();
    
    $ar = SqlGetAhSymbolArray();
    foreach ($ar as $strSymbolA => $strSymbolH)
    {
        $arPrefetch[] = $strSymbolA;
        $arSymbolH[] = $strSymbolH;
    }
    PrefetchStockData($arPrefetch);
    EchoAhParagraph($arSymbolH, $bChinese);
    
    EchoPromotionHead('ahcompare', $bChinese);
}

    AcctNoAuth();

?>

