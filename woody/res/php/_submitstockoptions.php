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
        while ($record = mysqli_fetch_assoc($result)) 
        {
//        	DebugString($record['date']);
            $ar[$record['id']] = floatval($record['adjclose']);
        }
        mysqli_free_result($result);
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
	if ($sql->WriteSymbol($strSymbol, $strVal))
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

function _updateStockOptionAdr($strSymbol, $strVal)
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
	$strAdr = StockGetSymbol($strAdr);

	if ($strStockId = SqlGetStockId($strAdr))
	{
		$pair_sql = new AdrPairSql();
		$pos_sql = new FundPositionSql();
		if ($strRatio == '0')
		{
			$pair_sql->DeleteBySymbol($strAdr);
			$pos_sql->DeleteById($strStockId);
		}
		else
		{
			$pair_sql->WritePairSymbol($strAdr, $strSymbol);
			if (intval($strRatio) != 1)		$pos_sql->WriteVal($strStockId, $strRatio); 
		}
	}
	else	DebugString($strAdr.' not in stock table');
}

function _updateStockOptionHa($strSymbolH, $strSymbolA)
{
	$pair_sql = new AhPairSql();
	if (empty($strSymbolA))		$pair_sql->DeleteByPairSymbol($strSymbolH);
	else							$pair_sql->WritePairSymbol($strSymbolA, $strSymbolH);
}

function _updateStockOptionAh($strSymbolA, $strSymbolH)
{
	$pair_sql = new AhPairSql();
	if (empty($strSymbolH))		$pair_sql->DeleteBySymbol($strSymbolA);
	else							$pair_sql->WritePairSymbol($strSymbolA, $strSymbolH);
}

function _updateStockOptionEmaDays($strStockId, $iDays, $strDate, $strVal)
{
	$sql = GetStockEmaSql($iDays);
	$sql->WriteDaily($strStockId, $strDate, $strVal);
}

function _updateStockOptionEma($strSymbol, $strStockId, $strDate, $strVal)
{
	SqlDeleteStockEma($strStockId);
	
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

function _updateStockOptionFund($strSymbol, $strVal)
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
		$strRatio = false;
	}
	
	$strStockId = SqlGetStockId($strSymbol);
	$pair_sql = new FundPairSql();
	$pos_sql = new FundPositionSql();
	if ($strRatio == '0')
	{
		$pair_sql->DeleteBySymbol($strSymbol);
		$pos_sql->DeleteById($strStockId);
	}
	else
	{
		$pair_sql->WritePairSymbol($strSymbol, StockGetSymbol($strIndex));
		if ($strRatio)	$pos_sql->WriteVal($strStockId, $strRatio); 
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
        while ($record = mysqli_fetch_assoc($result)) 
        {
        	_updateStockOptionSplitGroupTransactions($record['id'], $strStockId, $strDate, $fRatio, $fPrice);
        }
        mysqli_free_result($result);
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
		$nav_sql = GetNavHistorySql();
		$fNav = floatval($nav_sql->GetClose($strStockId, $strDate));
//		$fNav = floatval(SqlGetNavByDate($strStockId, $strDate));

		$fNewNav = $fNav - floatval($strVal); 
  		if ($strClose = $calibration_sql->GetClose($strStockId, $strDate))
  		{	// SPY
  			DebugString($strSymbol.' Change calibaration on '.$strDate);
  			$fFactor = floatval($strClose) * $fNav / $fNewNav;
  			$calibration_sql->WriteDaily($strStockId, $strDate, strval($fFactor));
  			$nav_sql->WriteDaily($strStockId, $strDate, strval($fNewNav));
  		}
  		else if ($strSymbol == 'XOP')
  		{
//  			$strQdii = 'SZ162411';	// 'SZ159518'
			foreach (QdiiGetXopSymbolArray() as $strQdii)
			{
				$strQdiiId = SqlGetStockId($strQdii);
				if ($strClose = $calibration_sql->GetClose($strQdiiId, $strDate))
				{
					DebugString($strQdii.' Change calibaration on '.$strDate);
					$fFactor = floatval($strClose) * $fNewNav / $fNav;
					$calibration_sql->WriteDaily($strQdiiId, $strDate, strval($fFactor));
				}
  			}
  		}
  		
		_updateStockHistoryAdjCloseByDividend($ref, $strSymbol, $strStockId, $his_sql, $strDate, $strVal);
	}
}

function _updateStockOptionCalibration($strSymbol, $strStockId, $strDate, $strVal)
{
	DebugString($strSymbol.' '.$strDate.' '.$strVal);
	if (!empty($strVal))
	{
		if (in_arrayChinaIndex($strSymbol))									return;
		else if (in_arrayQdii($strSymbol) || $strSymbol == 'SZ164906')		$strCNY = SqlGetNavByDate(SqlGetStockId('USCNY'), $strDate);
       	else if (in_arrayQdiiHk($strSymbol))									$strCNY = SqlGetNavByDate(SqlGetStockId('HKCNY'), $strDate);
       	else if (in_arrayQdiiJp($strSymbol))									$strCNY = SqlGetNavByDate(SqlGetStockId('JPCNY'), $strDate);
       	else if (in_arrayQdiiEu($strSymbol))									$strCNY = SqlGetNavByDate(SqlGetStockId('EUCNY'), $strDate);
		else 																	return;

		if ($strCNY == false)	return;
		$strNav = SqlGetNavByDate($strStockId, $strDate);
		if ($strNav == false)	return;
		$strVal = strval(QdiiGetCalibration($strVal, $strCNY, $strNav));
	}
	_updateOptionDailySql(new CalibrationSql(), $strStockId, $strDate, $strVal);
}

class _SubmitOptionsAccount extends Account
{
    public function Process($strLoginId)
    {
    	if (!isset($_POST['submit']))	return;

   		$bAdmin = $this->IsAdmin();
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
			
		case STOCK_OPTION_FUND:
			if ($bAdmin)	_updateStockOptionFund($strSymbol, $strVal);
			break;
			
		case STOCK_OPTION_HA:
			if ($bAdmin)	_updateStockOptionHa($strSymbol, $strVal);
			break;
			
		case STOCK_OPTION_CALIBRATION:
			if ($bAdmin)	_updateStockOptionCalibration($strSymbol, $strStockId, $strDate, $strVal);
			break;
			
		case STOCK_OPTION_HOLDINGS:
			if ($bAdmin)
			{
				switch ($strSymbol)
				{
				case 'SH513050':
				case 'SH513220':
				case 'SH513360':
				case 'SH513850':
					ReadSseHoldingsFile($strSymbol, $strStockId);
					break;
					
				case 'SZ159509':
				case 'SZ159577':
				case 'SZ159605':
				case 'SZ159607':
					ReadSzseHoldingsFile($strSymbol, $strStockId, $strDate);
					break;
					
				default:
					_updateStockOptionHoldings($strSymbol, $strStockId, $strDate, $strVal);
					break;
				}
			}
			break;
			
		case STOCK_OPTION_NAV:
			if ($bAdmin)
			{
				_updateOptionDailySql(GetNavHistorySql(), $strStockId, $strDate, $strVal);
				switch ($strSymbol)
				{
				case 'KWEB':
					ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strVal);
					_updateStockOptionCalibration('SZ164906', SqlGetStockId('SZ164906'), $strDate, $strVal);
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
}
?>
