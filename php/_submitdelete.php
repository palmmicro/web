<?php
require_once('account.php');
require_once('sql/sqlstocksymbol.php');
require_once('sql/sqlfundpurchase.php');
require_once('sql/sqlforex.php');
require_once('sql/sqlfundhistory.php');
require_once('sql/sqlstockhistory.php');
require_once('sql/sqlstockcalibration.php');
require_once('sql/sqlstockpair.php');
require_once('sql/sqlstockgroup.php');

function _deleteStockById($strStockId)
{
	$strSymbol = SqlGetStockSymbol($strStockId);
	$strFailed = $strSymbol.' delete failed - ';
	if (($iTotal = SqlCountStockGroupItemByStockId($strStockId)) > 0)
	{
		DebugString($strFailed.'Stock group item existed: '.strval($iTotal));
		return;
	}
	else if (($iTotal = SqlCountStockCalibration($strStockId)) > 0)
	{
		DebugString($strFailed.'Stock calibration existed: '.strval($iTotal));
		return;
	}
	else if (($iTotal = SqlCountFundPurchaseByStockId($strStockId)) > 0)
	{
		DebugString($strFailed.'Fund purchase existed: '.strval($iTotal));
		return;
	}
	else if (SqlGetStockPair(TABLE_ADRH_STOCK, $strStockId) || SqlGetStockPair(TABLE_AH_STOCK, $strStockId) || SqlGetStockPairStockId(TABLE_ADRH_STOCK, $strStockId) || SqlGetStockPairStockId(TABLE_AH_STOCK, $strStockId))
	{
		DebugString($strFailed.'Stock pair existed');
		return;
	}
	else if (SqlGetForexHistoryNow($strStockId) || SqlGetFundHistoryNow($strStockId))
	{
		DebugString($strFailed.'Stock history existed');
		return;
	}
	else if (($iTotal = SqlCountStockHistory($strStockId)) > 0)
	{
		$strWarning = 'Stock history existed: '.strval($iTotal);
		if ($iTotal > 100)	
		{
			DebugString($strFailed.$strWarning);
			return;
		}
		DebugString($strSymbol.' '.$strWarning);
		SqlDeleteStockHistory($strStockId);
	}
	SqlDeleteStock($strStockId);
}

    AcctNoAuth();
	if (AcctIsAdmin() || AcctIsDebug())
	{
	    if ($strPathName = UrlGetQueryValue('file'))
	    {
	        unlinkEmptyFile($strPathName);
	        EmailDebug('Deleted file: '.DebugFileLink($strPathName), 'Deleted debug file'); 
	    }
	    else if ($strStockId = UrlGetQueryValue('stockid'))
	    {
	    	_deleteStockById($strStockId);
	    }
	}
	
	SwitchToSess();

?>
