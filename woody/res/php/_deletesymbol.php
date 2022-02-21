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

function _deleteHasStockHistory($strStockId)
{
	$his_sql = GetStockHistorySql();
	$iTotal = $his_sql->Count($strStockId);
	if ($iTotal > 0)
	{
		DebugVal($iTotal, 'Stock history existed');
		$his_sql->DeleteAll($strStockId);
	}
	return false;
}

function _deleteHasNetValue($strStockId)
{
	$nav_sql = GetNavHistorySql();
	$iTotal = $nav_sql->Count($strStockId);
	if ($iTotal > 0)
	{
		DebugVal($iTotal, 'Net value history existed');
		$nav_sql->DeleteAll($strStockId);
	}
	return false;
}

function _deleteHasCalibration($strStockId)
{
   	$calibration_sql = new CalibrationSql();
	$iTotal = $calibration_sql->Count($strStockId);
	if ($iTotal > 0)
	{
		DebugVal($iTotal, 'Calibration history existed');
		$calibration_sql->DeleteAll($strStockId);
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
	else if (_deleteHasStockHistory($strStockId))							return;
	else if (_deleteHasNetValue($strStockId))								return;
	else if (_deleteHasCalibration($strStockId))								return;
	else if (($iTotal = SqlCountTableData(TABLE_STOCK_GROUP_ITEM, _SqlBuildWhere_stock($strStockId))) > 0)
	{
		DebugVal($iTotal, 'Stock group item existed');
		return;
	}
	else if (($iTotal = SqlCountFundPurchaseByStockId($strStockId)) > 0)
	{
		DebugVal($iTotal, 'Fund purchase existed');
		return;
	}

	DebugString('Deleted');
	$sql = GetStockSql();
	$sql->DeleteById($strStockId);
}

    $acct = new SymbolAccount();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
	        _deleteStockSymbol($ref);
	    }
	}
	$acct->Back();
	
?>
