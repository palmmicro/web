<?php

function RefHasData($ref)
{
	if ($ref)
	{
		return $ref->HasData();
	}
	return false;
}

function RefGetMyStockLink($ref)
{
	if ($ref)
	{
		return $ref->GetMyStockLink();
	}
	return '';
}

function RefSortByNumeric($arRef, $callback)
{
    $ar = array();
    $arNum = array();
    
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetSymbol();
        $ar[$strSymbol] = $ref;
    	$arNum[$strSymbol] = call_user_func($callback, $ref);
    }
    asort($arNum, SORT_NUMERIC);
    
    $arSort = array();
    foreach ($arNum as $strSymbol => $fNum)
    {
        $arSort[] = $ar[$strSymbol];
    }
    return $arSort;
}

function RefSortBySymbol($arRef)
{
    $ar = array();
    foreach ($arRef as $ref)
    {
        $strSymbol = $ref->GetSymbol();
		if (isset($ar[$strSymbol]) == false)		 $ar[$strSymbol] = $ref; 
    }
    ksort($ar);
    
    $arSort = array();
    foreach ($ar as $str => $ref)
    {
        $arSort[] = $ref;
    }
    return $arSort;
}

function RefSort($arRef)
{
	$arA = array();
    $arH = array();
    $arUS = array();

    foreach ($arRef as $ref)
    {
    	if ($ref->IsSymbolA())			$arA[] = $ref;
		else if ($ref->IsSymbolH())      	$arH[] = $ref;
		else			                	$arUS[] = $ref;
	}
	
	return array_merge(RefSortBySymbol($arA), RefSortBySymbol($arH), RefSortBySymbol($arUS));
}

function RefEchoTableColumn($ref, $ar, $strColor = false)
{
    EchoTableColumn($ar, $strColor, RefGetDescription($ref));
}

function GetArbitrageQuantity($strSymbol, $fQuantity)
{
  	switch ($strSymbol)
   	{
   	case 'SZ161127':
		$iArbitrage = 500;
   		break;
    		
   	case 'SZ162411':
		$iArbitrage = 1400;
   		break;
    		
   	case 'SZ163208':
		$iArbitrage = 550;
   		break;
    		
   	case 'SZ164906':
		$iArbitrage = 245;
   		break;
    		
   	default:
   		return '';
   	}
	return strval(intval($fQuantity / $iArbitrage + 0.5));
}

?>
