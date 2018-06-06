<?php
require_once('account.php');
require_once('sql/sqlstock.php');

function _deleteIsStockPair($strTableName, $strPairId)
{
	$sql = new PairStockSql($strPairId, $strTableName);
	if ($strStockId = $sql->GetStockId())
	{
		DebugString('Stock at least paired with: '.SqlGetStockSymbol($strStockId));
		return true;
	}
	return false;
}

function _deleteHasStockPair($strTableName, $strStockId)
{
	$sql = new PairStockSql($strStockId, $strTableName);
	if ($strPairId = $sql->GetPairId())
	{
		DebugString('Stock pair existed: '.SqlGetStockSymbol($strPairId));
		return true;
	}
	return false;
}

function _deleteHasStockHistory($sql)
{
	$iTotal = $sql->Count();
	if ($iTotal > 0)
	{
		DebugVal($iTotal, 'Stock history existed');
/*		if ($iTotal > 100)	
		{
			return true;
		}*/
		$sql->DeleteAll();
	}
	return false;
}

function _deleteStockById($strStockId)
{
	$strSymbol = SqlGetStockSymbol($strStockId);
	DebugString('Deleting '.$strSymbol);
	if (_deleteIsStockPair(TABLE_ADRH_STOCK, $strStockId))					return;
	else if (_deleteIsStockPair(TABLE_AH_STOCK, $strStockId))				return;
	else if (_deleteIsStockPair(TABLE_ETF_PAIR, $strStockId))				return;
	else if (_deleteHasStockPair(TABLE_ADRH_STOCK, $strStockId))				return;
	else if (_deleteHasStockPair(TABLE_AH_STOCK, $strStockId))				return;
	else if (_deleteHasStockPair(TABLE_ETF_PAIR, $strStockId))				return;
	else if (_deleteHasStockHistory(new StockHistorySql($strStockId)))	return;
	else if (_deleteHasStockHistory(new FundHistorySql($strStockId)))	return;
	else if (_deleteHasStockHistory(new ForexHistorySql($strStockId)))	return;
	else if (($iTotal = SqlCountStockGroupItemByStockId($strStockId)) > 0)
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
	SqlDeleteStock($strStockId);
}

    AcctNoAuth();
	if (AcctIsAdmin() || AcctIsDebug())
	{
	    if ($strPathName = UrlGetQueryValue('file'))
	    {
	        unlinkEmptyFile($strPathName);
	        EmailReport('Deleted file: '.GetFileLink($strPathName), 'Deleted debug file'); 
	    }
	    else if ($strStockId = UrlGetQueryValue('stockid'))
	    {
	    	_deleteStockById($strStockId);
	    }
	    else if ($strId = UrlGetQueryValue('etfcalibrationid'))
	    {
	    	SqlDeleteTableDataById(TABLE_ETF_CALIBRATION, $strId);
	    }
	}
	
	SwitchToSess();

?>
