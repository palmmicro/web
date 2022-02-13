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
    		
   	case 'SZ164906':
		$iArbitrage = 246;
   		break;
    		
   	default:
   		return '';
   	}
	return strval(intval($fQuantity / $iArbitrage + 0.5));
}

?>