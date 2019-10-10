<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stocktrans.php');
require_once('_editstockoptionform.php');

function _updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strYMD, $strDividend)
{
    $ar = array();
    $his_sql = $ref->GetHistorySql();
    if ($result = $his_sql->GetFromDate($strYMD)) 
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
        $his_sql->UpdateAdjClose($strId, strval($fAdjClose));
    }
    unlinkConfigFile($strSymbol);
}

function _updateStockHistoryClose($ref, $strSymbol, $strYMD, $strClose)
{
    $his_sql = $ref->GetHistorySql();
    if ($record = $his_sql->Get($strYMD)) 
    {
    	if ($his_sql->UpdateClose($record['id'], $strClose))
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
		trigger_error($_POST['submit'].' '.GetMyStockLink($strSymbol).' '.$strVal);
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
	if (strpos($strVal, '/') !== false)
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

function _updateStockOptionHa($strSymbolH, $strSymbolA)
{
	$pair_sql = new AhPairSql();
	if ($strA = $pair_sql->GetSymbol($strSymbolH))
	{
		if (empty($strSymbolA))
		{
			$pair_sql->DeleteBySymbol($strSymbolH);
		}
		else
		{
			if ($strSymbolA != $strA)
			{
				$pair_sql->DeleteBySymbol($strSymbolH);
				if ($strH = $pair_sql->GetPairSymbol($strSymbolA))
				{
					if ($strSymbolH != $strH)
					{
						$pair_sql->UpdateSymbol($strSymbolA, $strSymbolH);
					}
				}
				else
				{
					$pair_sql->InsertSymbol($strSymbolA, $strSymbolH);
				}
			}
		}
	}
	else
	{
		$pair_sql->InsertSymbol($strSymbolA, $strSymbolH);
	}
}

function _updateStockOptionAh($strSymbolA, $strSymbolH)
{
	$pair_sql = new AhPairSql();
	if ($strH = $pair_sql->GetPairSymbol($strSymbolA))
	{
		if (empty($strSymbolH))
		{
			$pair_sql->DeleteBySymbol($strH);
		}
		else
		{
			if ($strSymbolH != $strH)
			{
				$pair_sql->UpdateSymbol($strSymbolA, $strSymbolH);
			}
		}
	}
	else
	{
		$pair_sql->InsertSymbol($strSymbolA, $strSymbolH);
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
	if (strpos($strVal, '/') === false)		return;
	$ar = explode('/', $strVal);
	_updateStockOptionEmaDays($strStockId, 200, $strDate, $ar[0]);
	_updateStockOptionEmaDays($strStockId, 50, $strDate, $ar[1]);
    unlinkConfigFile($strSymbol);
}

function _updateStockOptionEtf($strSymbol, $strVal)
{
	if (strpos($strVal, '*') !== false)
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
    $pair_sql = new EtfPairSql($strStockId);
	if ($strRatio == '0')
	{
        $sql = new EtfCalibrationSql($strStockId);
        DebugVal($sql->Count(), 'Calibration');
        $sql->DeleteAll();
        $pair_sql->DeleteAll();
	}
	else
	{
		if ($record = $pair_sql->Get())
		{
			$pair_sql->Update($record['id'], $strPairId, $strRatio);
		}
		else
		{
			SqlInsertStockPair(TABLE_ETF_PAIR, $strStockId, $strPairId, $strRatio);
		}
	}
}

function _updateStockOptionNetValue($strStockId, $strDate, $strVal)
{
	$sql = new NetValueHistorySql($strStockId);
    if (empty($strVal))
    {
   		$sql->DeleteByDate($strDate);
    }
    else
    {
   		$sql->Write($strDate, $strVal);
    }
}

function _updateStockOptionSharesDiff($strStockId, $strDate, $strVal)
{
	$sql = new EtfSharesDiffSql($strStockId);
    if ($strVal == '0')
    {
//   		$sql->DeleteAll();
    }
    else
    {
   		$sql->Write($strDate, $strVal);
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
	if (strpos($strVal, ':') === false)		return;
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
		$strDate = isset($_POST['date']) ? UrlCleanString($_POST['date']) : '';
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
			if ($bAdmin)	_updateStockOptionAh($strSymbol, $strVal);
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
			
		case STOCK_OPTION_HA:
			if ($bAdmin)	_updateStockOptionHa($strSymbol, $strVal);
			break;
			
		case STOCK_OPTION_NETVALUE:
			if ($bAdmin)	_updateStockOptionNetValue($strStockId, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_SHARES_DIFF:
			if ($bAdmin)	_updateStockOptionSharesDiff($strStockId, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_SPLIT:
			if ($bAdmin)	_updateStockOptionSplit($ref, $strSymbol, $strStockId, $strDate, $strVal);
			break;
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
