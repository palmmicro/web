<?php
require_once('_stock.php');
//require_once('_editstockoptionform.php');
require_once('_kraneholdingscsv.php');
require_once('_sseholdings.php');
require_once('_szseholdings.php');

function _updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strStockId, $his_sql, $strYMD, $strDividend)
{
    $ar = array();
    if ($result = $his_sql->GetFromDate($strStockId, $strYMD)) 
    {
//    	DebugString('START: '.$strYMD);
        while ($record = mysql_fetch_assoc($result)) 
        {
//        	DebugString($record['date']);
            $ar[$record['id']] = floatval($record['adjclose']);
        }
        @mysql_free_result($result);
    }

	$fDividend = floatval($strDividend);
    foreach ($ar as $strId => $fAdjClose)
    {
        $fAdjClose -= $fDividend;
//        $fAdjClose *= 4;
        $his_sql->UpdateAdjClose($strId, strval($fAdjClose));
    }
    unlinkConfigFile($strSymbol);
}

function _updateStockHistoryClose($ref, $strSymbol, $strStockId, $his_sql, $strYMD, $strClose)
{
    if ($record = $his_sql->GetRecord($strStockId, $strYMD)) 
    {
    	if ($his_sql->UpdateClose($record['id'], $strClose))
        {
        	unlinkConfigFile($strSymbol);
        }
    }
}

function _updateStockDescription($strSymbol, $strVal)
{
	$sql = GetStockSql();
	if ($sql->WriteSymbol($strSymbol, $strVal, false))
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
	$sql = new PairStockSql($strTable, $strStockId);
	if ($strRatio == '0')
	{
		$sql->DeleteAll();
	}
	else
	{
		if ($record = $sql->GetRecord())
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
	$sql = GetStockEmaSql($iDays);
	$sql->DeleteAll($strStockId);
    if ($strVal == '0')
    {
    }
    else
    {
   		$sql->WriteDaily($strStockId, $strDate, $strVal);
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

function _updateStockOptionHoldings($strSymbol, $strStockId, $strDate, $strVal)
{
	$sql = GetStockSql();
	$holdings_sql = GetHoldingsSql();
	$date_sql = new HoldingsDateSql();
	
	$date_sql->WriteDate($strStockId, $strDate);
	$holdings_sql->DeleteAll($strStockId);
	
	$ar = explode(';', $strVal);
	foreach ($ar as $str)
	{
		$arHolding = explode('*', $str);
		if (count($arHolding) == 2)
		{
			$strHolding = StockGetSymbol($arHolding[0]);
			$strRatio = $arHolding[1];
			if ($strRatio == '0')
			{	// delete
			}
			else
			{
				$holdings_sql->InsertHolding($strStockId, $sql->GetId($strHolding), $strRatio);
			}
		}
	}
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
        $pair_sql->DeleteAll();
	}
	else
	{
		if ($record = $pair_sql->GetRecord())
		{
			$pair_sql->Update($record['id'], $strPairId, $strRatio);
		}
		else
		{
			SqlInsertStockPair(TABLE_ETF_PAIR, $strStockId, $strPairId, $strRatio);
		}
	}
}

function _updateOptionDailySql($sql, $strStockId, $strDate, $strVal)
{
	return $sql->ModifyDaily($strStockId, $strDate, $strVal);
}

function _updateStockOptionSplitGroupTransactions($strGroupId, $strStockId, $strDate, $fRatio, $fPrice)
{
	$sql = new StockGroupItemSql($strGroupId);
    if ($arStockId = $sql->GetStockIdArray(true))
    {
    	if (in_array($strStockId, $arStockId))
    	{
    		$record = $sql->GetRecord($strStockId);
//    		$strGroupItemId = $sql->GetId($strStockId);
    		$strGroupItemId = $record['id'];
    		$iQuantity = intval($record['quantity']);
    		$sql->trans_sql->Insert($strGroupItemId, strval(0 - $iQuantity), strval($fPrice));
    		$sql->trans_sql->Insert($strGroupItemId, strval(intval($fRatio * $iQuantity)), strval($fPrice / $fRatio));
    		UpdateStockGroupItemTransaction($sql, $strGroupItemId);
    	}
    }
}

function _updateStockOptionSplitTransactions($ref, $strStockId, $his_sql, $strDate, $fRatio)
{
    $fPrice = floatval($his_sql->GetClosePrev($strStockId, $strDate));
    
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

function _updateStockOptionSplit($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal)
{
	if (strpos($strVal, ':') === false)		return;
	$ar = explode(':', $strVal);
	
	$sql = new StockSplitSql();
	if ($ar[0] == '0' && $ar[1] == '0')
	{
   		$sql->DeleteByDate($strStockId, $strDate);
	}
	else
	{
		$fRatio = floatval($ar[0])/floatval($ar[1]);
//		DebugVal($fRatio, $strSymbol);
		if ($sql->InsertDaily($strStockId, $strDate, strval($fRatio)))
		{
			_updateStockOptionSplitTransactions($ref, $strStockId, $his_sql, $strDate, $fRatio);
		}
	}
}

function _updateStockOptionDividend($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal)
{
	$sql = new StockDividendSql();
	if (_updateOptionDailySql($sql, $strStockId, $strDate, $strVal))
	{
		DebugString('Dividend updated');
		$calibration_sql = new CalibrationSql();
		$fNav = floatval(SqlGetNavByDate($strStockId, $strDate));
		$fNewNav = $fNav - floatval($strVal); 
  		if ($strClose = $calibration_sql->GetClose($strStockId, $strDate))
  		{	// SPY
  			DebugString($strSymbol.' Change calibaration on '.$strDate);
  			$fFactor = floatval($strClose) * $fNav / $fNewNav;
  			$calibration_sql->WriteDaily($strStockId, $strDate, strval($fFactor));
  		}
  		else if ($strSymbol == 'XOP')
  		{
  			$strLof = 'SZ162411';
  			$strLofId = SqlGetStockId($strLof);
  			if ($strClose = $calibration_sql->GetClose($strLofId, $strDate))
  			{
  				DebugString($strLof.' Change calibaration on '.$strDate);
  				$fFactor = floatval($strClose) * $fNewNav / $fNav;
  				$calibration_sql->WriteDaily($strLofId, $strDate, strval($fFactor));
  			}
  		}
  		
		_updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal);
	}
}

   	$acct = new Account();
	
   	if ($acct->GetLoginId() && isset($_POST['submit']))
	{
   		$bAdmin = $acct->IsAdmin();
   		
		$strEmail = SqlCleanString($_POST['login']);
		$strSymbol = SqlCleanString($_POST['symbol']);
		$strDate = isset($_POST['date']) ? SqlCleanString($_POST['date']) : '';
		$strVal = SqlCleanString($_POST['val']);
		
    	StockPrefetchExtendedData($strSymbol);
        $ref = StockGetReference($strSymbol);
		$strStockId = $ref->GetStockId();
		$his_sql = GetStockHistorySql();
        
		switch ($_POST['submit'])
		{
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
			if ($bAdmin)	_updateStockHistoryClose($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_DIVIDEND:
			if ($bAdmin)	_updateStockOptionDividend($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_EDIT:
			if ($bAdmin)	_updateStockDescription($strSymbol, $strVal);
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
			
		case STOCK_OPTION_HOLDINGS:
			if ($bAdmin)
			{
//				_updateStockOptionHoldings($strSymbol, $strStockId, $strDate, $strVal);
				switch ($strSymbol)
				{
				case 'SH513050':
					ReadSseHoldingsFile($strSymbol, $strStockId);
					break;
					
				case 'SZ159605':
				case 'SZ159607':
					ReadSzseHoldingsFile($strSymbol, $strStockId, $strDate);
					break;
				}
			}
			break;
			
		case STOCK_OPTION_NETVALUE:
			if ($bAdmin)
			{
				_updateOptionDailySql(GetNavHistorySql(), $strStockId, $strDate, $strVal);
				switch ($strSymbol)
				{
				case 'KWEB':
					//SaveKraneHoldingsCsvFile($strSymbol, $strDate);
					ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strVal);
					break;
				}
			}
			break;
			
		case STOCK_OPTION_SHARE_DIFF:
			if ($bAdmin)	_updateOptionDailySql(new SharesDiffSql(), $strStockId, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_SPLIT:
			if ($bAdmin)	_updateStockOptionSplit($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal);
			break;
		}
		unset($_POST['submit']);
	}

	$acct->Back();
?>
