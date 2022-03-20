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

function RefEchoTableColumn($ref, $ar, $strColor = false)
{
    EchoTableColumn($ar, $strColor, SymGetStockName($ref));
}

function GetArbitrageRatio($strStockId)
{
	if ($iArbitrage = FundGetArbitrage($strStockId))	return $iArbitrage;
	return 1;
}

function GetArbitrageQuantity($strStockId, $fQuantity)
{
	return strval(round($fQuantity / GetArbitrageRatio($strStockId)));
}

function GetTurnoverDisplay($fVolume, $fShare)
{
	return strval_round(100.0 * $fVolume / ($fShare * 10000.0), 2).'%';
}

?>
