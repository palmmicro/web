<?php
require_once('mysqlstock.php');
require_once('mysqllof.php');
require_once('mysqlgold.php');
require_once('mysqlgraded.php');

function WeixinStockPrefetchData($ar)
{
    $arAll = array();
    foreach ($ar as $strSymbol)
    {
        if (StockFundFromCN($strSymbol))
        {
            if (in_arrayLof($strSymbol))                $arAll = array_merge($arAll, LofGetAllSymbolArray($strSymbol));
            else if (in_arrayLofHk($strSymbol))         $arAll = array_merge($arAll, LofHkGetAllSymbolArray($strSymbol));
            else if (in_arrayGoldEtf($strSymbol))       $arAll = array_merge($arAll, GoldEtfGetAllSymbolArray($strSymbol));
            else if (in_arrayGradedFund($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbol));
            else if ($strSymbolA = in_arrayGradedFundB($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbolA));
            else if ($strSymbolA = in_arrayGradedFundM($strSymbol))    $arAll = array_merge($arAll, GradedFundGetAllSymbolArray($strSymbolA));
        }
        else
        {
            $arAll[] = $strSymbol; 
        }
    }
    PrefetchStockData(array_unique($arAll));
}

function WeixinStockGetFundReference($strSymbol)
{
    if (in_arrayLof($strSymbol))                 $ref = new MyLofReference($strSymbol);
    else if (in_arrayLofHk($strSymbol))         $ref = new MyLofHkReference($strSymbol);
    else if (in_arrayGoldEtf($strSymbol))       $ref = new MyGoldEtfReference($strSymbol);
    else if (in_arrayGradedFund($strSymbol))    $ref = new MyGradedFundReference($strSymbol);
    else if ($strSymbolA = in_arrayGradedFundB($strSymbol))
    {
        $a_ref = new MyGradedFundReference($strSymbolA);
        $ref = $a_ref->b_ref;
    }
    else if ($strSymbolA = in_arrayGradedFundM($strSymbol))
    {
        $a_ref = new MyGradedFundReference($strSymbolA);
        $ref = $a_ref->m_ref;
    }
    else
    {
        $ref = new MyFundReference($strSymbol);
    }
    return $ref;
}

?>
