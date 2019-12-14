<?php
require_once('_stock.php');
require_once('_emptygroup.php');

function _deleteIsStockPair($strTableName, $strPairId)
{
	$sql = new PairStockSql($strTableName, $strPairId);
	if ($strStockId = $sql->GetFirstStockId())
	{
		DebugString('Stock at least paired with: '.SqlGetStockSymbol($strStockId));
		return true;
	}
	return false;
}

function _deleteHasStockPair($strTableName, $strStockId)
{
	$sql = new PairStockSql($strTableName, $strStockId);
	if ($strPairId = $sql->GetPairId())
	{
		DebugString('Stock pair existed: '.SqlGetStockSymbol($strPairId));
		return true;
	}
	return false;
}

function _deleteHasAhPair($strSymbol)
{
	$sql = new AhPairSql();
	if ($strSymbolH = $sql->GetPairSymbol($strSymbol))
	{
		DebugString('H stock existed: '.$strSymbolH);
		return true;
	}
	else if ($strSymbolA = $sql->GetSymbol($strSymbol))
	{
		DebugString('A stock existed: '.$strSymbolA);
		return true;
	}
	return false;
}

function _deleteHasStockHistory($his_sql)
{
	$iTotal = $his_sql->Count();
	if ($iTotal > 0)
	{
		DebugVal($iTotal, 'Stock history existed');
/*		if ($iTotal > 100)	
		{
			return true;
		}*/
		$his_sql->DeleteAll();
	}
	return false;
}

function _deleteStockSymbol($ref)
{
	$strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();

	DebugString('Deleting... '.$strSymbol);
	if (_deleteIsStockPair(TABLE_ADRH_STOCK, $strStockId))					return;
	else if (_deleteIsStockPair(TABLE_ETF_PAIR, $strStockId))				return;
	else if (_deleteHasStockPair(TABLE_ADRH_STOCK, $strStockId))				return;
	else if (_deleteHasStockPair(TABLE_ETF_PAIR, $strStockId))				return;
	else if (_deleteHasAhPair($strSymbol))									return;
	else if (_deleteHasStockHistory($ref->GetHistorySql()))					return;
	else if (_deleteHasStockHistory(new NetValueHistorySql($strStockId)))	return;
	else if (($iTotal = SqlCountTableData(TABLE_STOCK_GROUP_ITEM, _SqlBuildWhere_stock($strStockId))) > 0)
	{
		DebugVal($iTotal, 'Stock group item existed');
		return;
	}
	else if (($iTotal = SqlCountStockCalibration($strStockId)) > 0)
	{
		DebugVal($iTotal, 'Stock calibration existed');
		return;
	}
	else if (($iTotal = SqlCountFundPurchaseByStockId($strStockId)) > 0)
	{
		DebugVal($iTotal, 'Fund purchase existed');
		return;
	}

	DebugString('Deleted');
	$sql = new StockSql();
	$sql->DeleteById($strStockId);
}

    $acct = new SymbolAcctStart();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
	        _deleteStockSymbol($ref);
	    }
	}
	$acct->Back();
	
?>
