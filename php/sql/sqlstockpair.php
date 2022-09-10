<?php
require_once('sqlpair.php');

class StockPairSql extends PairSql
{
	var $sql;
	
    function StockPairSql($strTableName)
    {
        parent::PairSql($strTableName);
        
		$this->sql = GetStockSql();
    }
    
    function GetSymbolArray($strPairSymbol = false)
    {
		$arSymbol = array();
		if ($strPairSymbol)
		{
			if ($strPairId = $this->sql->GetId($strPairSymbol))		$ar = $this->GetIdArray($strPairId);
			else	return $arSymbol; 
		}
		else																$ar = $this->GetIdArray();
		
		if (count($ar) > 0)
		{
			foreach ($ar as $strStockId)	$arSymbol[] = $this->sql->GetStockSymbol($strStockId);
			sort($arSymbol);
		}
		return $arSymbol;
	}
	
	function GetSymbol($strPairSymbol)
	{
		if ($strPairId = $this->sql->GetId($strPairSymbol))
		{
			if ($strStockId = $this->GetId($strPairId))
			{
				return $this->sql->GetStockSymbol($strStockId);
			}
		}
		return false;
	}
	
	function GetPairSymbol($strSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			if ($strPairId = $this->ReadPair($strStockId))
			{
				return $this->sql->GetStockSymbol($strPairId);
			}
		}
		return false;
	}

	function WriteSymbol($strSymbol, $strPairSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			if ($strPairId = $this->sql->GetId($strPairSymbol))
			{
				return $this->WritePair($strStockId, $strPairId);
			}
		}
		return false;
	}
	
	function DeleteBySymbol($strSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			return $this->DeleteById($strStockId);
		}
		return false;
	}
	
	function DeleteByPairSymbol($strPairSymbol)
	{
		if ($strPairId = $this->sql->GetId($strPairSymbol))
		{
			return $this->Delete($strPairId);
		}
		return false;
	}
}

class AdrPairSql extends StockPairSql
{
    function AdrPairSql()
    {
        parent::StockPairSql('adrpair');
    }
}

class AhPairSql extends StockPairSql
{
    function AhPairSql() 
    {
        parent::StockPairSql('ahpair');
    }
}

class AbPairSql extends StockPairSql
{
    function AbPairSql() 
    {
        parent::StockPairSql('abpair');
    }
}

class FundPairSql extends StockPairSql
{
    function FundPairSql() 
    {
        parent::StockPairSql('fundpair');
    }
}

function SqlGetFundPair($strFund)
{
	$pair_sql = new FundPairSql();
	return $pair_sql->GetPairSymbol($strFund);
}

function SqlGetAbPair($strSymbolA)
{
	$pair_sql = new AbPairSql();
	return $pair_sql->GetPairSymbol($strSymbolA);
}

function SqlGetBaPair($strSymbolB)
{
	$pair_sql = new AbPairSql();
	return $pair_sql->GetSymbol($strSymbolB);
}

function SqlGetAhPair($strSymbolA)
{
	$pair_sql = new AhPairSql();
	return $pair_sql->GetPairSymbol($strSymbolA);
}

function SqlGetHaPair($strSymbolH)
{
	$pair_sql = new AhPairSql();
	return $pair_sql->GetSymbol($strSymbolH);
}

function SqlGetAdrhPair($strSymbolAdr)
{
	$pair_sql = new AdrPairSql();
	return $pair_sql->GetPairSymbol($strSymbolAdr);
}

function SqlGetHadrPair($strSymbolH)
{
	$pair_sql = new AdrPairSql();
	return $pair_sql->GetSymbol($strSymbolH);
}

?>
