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
                if ($strSymbolH = SqlGetAhPair($strSymbol))	
                {
                	$arAll[] = $strSymbolH;
                	if ($strSymbolAdr = SqlGetHadrPair($strSymbolH))	$arAll[] = $strSymbolAdr;
                }
            }
            else if ($sym->IsSymbolH())
            {
                if ($strSymbolA = SqlGetHaPair($strSymbol))			$arAll[] = $strSymbolA;
                if ($strSymbolAdr = SqlGetHadrPair($strSymbol))	$arAll[] = $strSymbolAdr;
            }
            else
            {
            	if ($strSymbolH = SqlGetAdrhPair($strSymbol))
            	{
                	$arAll[] = $strSymbolH;
                	if ($strSymbolA = SqlGetHaPair($strSymbolH))	$arAll[] = $strSymbolA;
                }
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

function MyStockGetReference($sym)
{
	$strSymbol = $sym->strSymbol;
    if ($sym->IsSinaFund())
    {
    }
    else if ($strFutureSymbol = $sym->IsSinaFuture())   	return new MyFutureReference($strFutureSymbol);
    else if ($sym->IsSinaForex())   							return new MyForexReference($strSymbol);
	else if ($sym->IsEastMoneyForex())						return new MyCnyReference($strSymbol);
    return new MyStockReference($strSymbol);
}

function MyStockGetHAdrReference($sym)
{
	$strSymbol = $sym->strSymbol;
   	if ($sym->IsSymbolA())
   	{
    	if ($strSymbolH = SqlGetAhPair($strSymbol))
    	{
    		$a_ref = new MyStockReference($strSymbol);
    		if ($strSymbolAdr = SqlGetHadrPair($strSymbolH))
    		{
    			$hadr_ref = new MyHAdrReference($strSymbolH, $a_ref, new MyStockReference($strSymbolAdr));
    			return array($a_ref, $hadr_ref, $hadr_ref);
    		}
    		else	return array($a_ref, new MyHShareReference($strSymbolH, $a_ref), false);
      	}
    }
    else if ($sym->IsSymbolH())
    {
        if ($strSymbolAdr = SqlGetHadrPair($strSymbol))	
        {
    		$adr_ref = new MyStockReference($strSymbolAdr);
    		if ($strSymbolA = SqlGetHaPair($strSymbol))	
    		{
    			$hadr_ref = new MyHAdrReference($strSymbol, new MyStockReference($strSymbolA), $adr_ref);
    			return array($hadr_ref, $hadr_ref, $hadr_ref);
    		}
            else
            {
            	$hadr_ref = new MyHAdrReference($strSymbol, false, $adr_ref);
            	return array($hadr_ref, false, $hadr_ref);
            }
        }
        else if ($strSymbolA = SqlGetHaPair($strSymbol))	
        {
        	$hshare_ref = new MyHShareReference($strSymbol, new MyStockReference($strSymbolA));
            return array($hshare_ref, $hshare_ref, false);
        }
    }
   	else 	// if ($sym->IsSymbolUS())
   	{
    	if ($strSymbolH = SqlGetAdrhPair($strSymbol))
    	{
    		$adr_ref = new MyStockReference($strSymbol);
    		if ($strSymbolA = SqlGetHaPair($strSymbolH))
    		{
    			$hadr_ref = new MyHAdrReference($strSymbolH, new MyStockReference($strSymbolA), $adr_ref);
    			return array($adr_ref, $hadr_ref, $hadr_ref);
    		}
    		else	return array($adr_ref, false, new MyHAdrReference($strSymbolH, false, $adr_ref));
      	}
    }
    return false;
}

?>
