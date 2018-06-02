<?php
require_once('account.php');
require_once('sql/sqlstocksymbol.php');
require_once('sql/sqlfundpurchase.php');
require_once('sql/sqlstockdaily.php');
require_once('sql/sqlfundhistory.php');
require_once('sql/sqlstockhistory.php');
require_once('sql/sqlstockcalibration.php');
require_once('sql/sqlstockpair.php');
require_once('sql/sqlstockgroup.php');

function _deleteIsStockPair($strTableName, $strPairId)
{
	$sql = new PairStockSql($strPairId, $strTableName);
	if ($strStockId = $sql->GetStockIdByPairId())
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

function _deleteHasStockHistory($strStockId)
{
	$sql = new StockHistorySql($strStockId);
	$iTotal = $sql->Count();
	if ($iTotal > 0)
	{
		DebugString('Stock history existed: '.strval($iTotal));
		if ($iTotal > 100)	
		{
			return true;
		}
		$sql->DeleteAll();
	}
	return false;
}

function _deleteStockById($strStockId)
{
	$strSymbol = SqlGetStockSymbol($strStockId);
	DebugString('Deleting '.$strSymbol);
	if (_deleteIsStockPair(TABLE_ADRH_STOCK, $strStockId))			return;
	else if (_deleteIsStockPair(TABLE_AH_STOCK, $strStockId))		return;
	else if (_deleteIsStockPair(TABLE_ETF_PAIR, $strStockId))		return;
	else if (_deleteHasStockPair(TABLE_ADRH_STOCK, $strStockId))		return;
	else if (_deleteHasStockPair(TABLE_AH_STOCK, $strStockId))		return;
	else if (_deleteHasStockPair(TABLE_ETF_PAIR, $strStockId))		return;
	else if (_deleteHasStockHistory($strStockId))					return;
	else if (($iTotal = SqlCountStockGroupItemByStockId($strStockId)) > 0)
	{
		DebugString('Stock group item existed: '.strval($iTotal));
		return;
	}
	else if (($iTotal = SqlCountStockCalibration($strStockId)) > 0)
	{
		DebugString('Stock calibration existed: '.strval($iTotal));
		return;
	}
	else if (($iTotal = SqlCountFundPurchaseByStockId($strStockId)) > 0)
	{
		DebugString('Fund purchase existed: '.strval($iTotal));
		return;
	}
	else if (SqlGetForexHistoryNow($strStockId) || SqlGetFundHistoryNow($strStockId))
	{
		DebugString('Stock history existed');
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
