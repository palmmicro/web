<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
require_once('_editstockoptionform.php');

function _updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strYMD, $strDividend)
{
    $ar = array();
    $sql = $ref->GetHistorySql();
    if ($result = $sql->GetFromDate($strYMD)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $ar[$record['id']] = floatval($record['adjclose']);
        }
        @mysql_free_result($result);
    }

	$fDividend = floatval($strDividend);
    foreach ($ar as $strId => $fAdjClose)
    {
        $fAdjClose -= $fDividend;
        $sql->UpdateAdjClose($strId, strval($fAdjClose));
    }
    unlinkConfigFile($strSymbol);
}

function _updateStockHistoryClose($ref, $strSymbol, $strYMD, $strClose)
{
    $sql = $ref->GetHistorySql();
    if ($record = $sql->Get($strYMD)) 
    {
    	if ($sql->UpdateClose($record['id'], $strClose))
        {
        	unlinkConfigFile($strSymbol);
        }
    }
}

function _updateStockDescription($strSymbol, $strStockId, $strVal)
{
	$sql = new StockSql();
	if ($sql->Update($strStockId, $strSymbol, $strVal))
	{
		EmailReport(GetMyStockLink($strSymbol).' '.$strVal, $_POST['submit']);
	}
}

function _updateFundPurchaseAmount($strEmail, $strSymbol, $strVal)
{
	$strMemberId = SqlGetIdByEmail($strEmail);
	$strStockId = SqlGetStockId($strSymbol);
	if ($strMemberId && $strStockId && is_numeric($strVal))
	{
    	if ($str = SqlGetFundPurchaseAmount($strMemberId, $strStockId))
    	{
    		if ($str != $strVal)
    		{
    			SqlUpdateFundPurchase($strMemberId, $strStockId, $strVal);
    		}
    	}
    	else
    	{
    		SqlInsertFundPurchase($strMemberId, $strStockId, $strVal);
    	}
	}
}

function _updateStockOptionAdr($strSymbol, $strVal, $strTable = TABLE_ADRH_STOCK)
{
	if (strstr($strVal, '/'))
	{
		$ar = explode('/', $strVal);
		$strAdr = $ar[0];
		$strRatio = $ar[1];
	}
	else
	{
		$strAdr = $strVal;
		$strRatio = '1';
	}
	$strPairId = SqlGetStockId($strSymbol);
	
	$adr_ref = new MyStockReference(StockGetSymbol($strAdr)); 
	$strStockId = $adr_ref->GetStockId();
	$sql = new PairStockSql($strStockId, $strTable);
	if ($strRatio == '0')
	{
		$sql->DeleteAll();
	}
	else
	{
		if ($record = $sql->Get())
		{
			$sql->Update($record['id'], $strPairId, $strRatio);
		}
		else
		{
			SqlInsertStockPair($strTable, $strStockId, $strPairId, $strRatio);
		}
	}
}

function _updateStockOptionEmaDays($strStockId, $iDays, $strDate, $strVal)
{
	$sql = new StockEmaSql($strStockId, $iDays);
    if ($strVal == '0')
    {
   		$sql->DeleteAll();
    }
    else
    {
   		$sql->Write($strDate, $strVal);
    }
}

function _updateStockOptionEma($strSymbol, $strStockId, $strDate, $strVal)
{
	if (strstr($strVal, '/') == false)		return;
	$ar = explode('/', $strVal);
	_updateStockOptionEmaDays($strStockId, 200, $strDate, $ar[0]);
	_updateStockOptionEmaDays($strStockId, 50, $strDate, $ar[1]);
    unlinkConfigFile($strSymbol);
}

function _updateStockOptionEtf($strSymbol, $strVal)
{
	if (strstr($strVal, '*'))
	{
		$ar = explode('*', $strVal);
		$strIndex = $ar[0];
		$strRatio = $ar[1];
	}
	else
	{
		$strIndex = $strVal;
		$strRatio = '1';
	}
	$strPairId = SqlGetStockId(StockGetSymbol($strIndex));
	$strStockId = SqlGetStockId($strSymbol);
	if ($strRatio == '0')
	{
        $sql = new EtfCalibrationSql($strStockId);
        DebugVal($sql->Count(), 'Calibration');
        $sql->DeleteAll();
        $sql->pair_sql->DeleteAll();
	}
	else
	{
		$sql = new PairStockSql($strStockId, TABLE_ETF_PAIR);
		if ($record = $sql->Get())
		{
			$sql->Update($record['id'], $strPairId, $strRatio);
		}
		else
		{
			SqlInsertStockPair(TABLE_ETF_PAIR, $strStockId, $strPairId, $strRatio);
		}
	}
}

function _updateStockOptionSplitGroupTransactions($strGroupId, $strStockId, $strDate, $fRatio, $fPrice)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arStockId = $sql->GetStockIdArray(true);
    if (in_array($strStockId, $arStockId))
    {
    	$record = $sql->Get($strStockId);
//    	$strGroupItemId = $sql->GetId($strStockId);
    	$strGroupItemId = $record['id'];
    	$iQuantity = intval($record['quantity']);
    	$sql->trans_sql->Insert($strGroupItemId, strval(0 - $iQuantity), strval($fPrice));
    	$sql->trans_sql->Insert($strGroupItemId, strval(intval($fRatio * $iQuantity)), strval($fPrice / $fRatio));
    	UpdateStockGroupItemTransaction($sql, $strGroupItemId);
    }
}

function _updateStockOptionSplitTransactions($ref, $strStockId, $strDate, $fRatio)
{
    $fPrice = floatval($ref->his_sql->GetClosePrev($strDate));
    
	$sql = new TableSql(TABLE_STOCK_GROUP);
    if ($result = $sql->GetData())
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	_updateStockOptionSplitGroupTransactions($record['id'], $strStockId, $strDate, $fRatio, $fPrice);
        }
        @mysql_free_result($result);
    }
}

function _updateStockOptionSplit($ref, $strSymbol, $strStockId, $strDate, $strVal)
{
	if (strstr($strVal, ':') == false)		return;
	$ar = explode(':', $strVal);
	$fRatio = floatval($ar[0])/floatval($ar[1]);
//	DebugVal($fRatio, $strSymbol);
	
	$sql = new StockSplitSql($strStockId);
	if ($sql->Insert($strDate, strval($fRatio)))
	{
		_updateStockOptionSplitTransactions($ref, $strStockId, $strDate, $fRatio);
	}
}

	AcctAuth();
	if (isset($_POST['submit']))
	{
		$strEmail = UrlCleanString($_POST['login']);
		$strSymbol = UrlCleanString($_POST['symbol']);
		$strDate = UrlCleanString($_POST['date']);
		$strVal = UrlCleanString($_POST['val']);
   		$bAdmin = AcctIsAdmin();
		$strStockId = SqlGetStockId($strSymbol);
		
    	StockPrefetchData($strSymbol);
        $ref = StockGetReference($strSymbol);
        
		switch ($_POST['submit'])
		{
		case STOCK_OPTION_ADJCLOSE:
			if ($bAdmin)	_updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_ADR:
			if ($bAdmin)	_updateStockOptionAdr($strSymbol, $strVal);
			break;
			
		case STOCK_OPTION_AH:
			if ($bAdmin)	_updateStockOptionAdr($strSymbol, $strVal, TABLE_AH_STOCK);
			break;
			
		case STOCK_OPTION_AMOUNT:
			_updateFundPurchaseAmount($strEmail, $strSymbol, $strVal);
			break;

		case STOCK_OPTION_CLOSE:
			if ($bAdmin)	_updateStockHistoryClose($ref, $strSymbol, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_EDIT:
			if ($bAdmin)	_updateStockDescription($strSymbol, $strStockId, $strVal);
			break;
			
		case STOCK_OPTION_EMA:
			if ($bAdmin)	_updateStockOptionEma($strSymbol, $strStockId, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_ETF:
			if ($bAdmin)	_updateStockOptionEtf($strSymbol, $strVal);
			break;
			
		case STOCK_OPTION_SPLIT:
			if ($bAdmin)	_updateStockOptionSplit($ref, $strSymbol, $strStockId, $strDate, $strVal);
			break;
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
