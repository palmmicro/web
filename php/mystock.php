<?php
require_once('mysqlstock.php');
require_once('mysqllof.php');
require_once('mysqlgold.php');
require_once('mysqlgraded.php');

function _prefetchStockData($arStockSymbol)
{
    $arUnknown = PrefetchSinaStockData($arStockSymbol);
    $arUnknown = PrefetchGoogleStockData($arUnknown);
    PrefetchYahooData($arUnknown);
}

function MyStockPrefetchData($ar)
{
    $arAll = array();
    foreach ($ar as $strSymbol)
    {
    	$sym = new StockSymbol($strSymbol);
        if ($sym->IsFundA())
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
            if ($sym->IsSymbolA())
            {
                if ($strSymbolH = SqlGetAhPair($strSymbol))		$arAll[] = $strSymbolH; 
            }
            else if ($sym->IsSymbolH())
            {
                if ($strSymbolA = SqlGetHaPair($strSymbol))		$arAll[] = $strSymbolA;
            }
            $arAll[] = $strSymbol; 
        }
    }
    _prefetchStockData(array_unique($arAll));
}

function MyStockPrefetchDataAndForex($arStockSymbol)
{
    MyStockPrefetchData($arStockSymbol);
    PrefetchEastMoneyData(array('USCNY', 'HKCNY'));
}

function MyStockGetFundReference($strSymbol)
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

function MyStockGetHShareReference($sym)
{
	$strSymbol = $sym->strSymbol;
   	if ($sym->IsSymbolA())
   	{
    	if ($strSymbolH = SqlGetAhPair($strSymbol))
    	{
    		return (new MyHShareReference($strSymbolH, new MyStockReference($strSymbol)));
      	}
    }
    else if ($sym->IsSymbolH())
    {
        if ($strSymbolA = SqlGetHaPair($strSymbol))	
        {
            return (new MyHShareReference($strSymbol, new MyStockReference($strSymbolA)));
        }
    }
    return false;
}

?>
