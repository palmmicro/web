<?php
require_once('_fundgroup.php');
require_once('_kraneholdingscsv.php');
require_once('_sseholdings.php');
require_once('_szseholdings.php');

// SH501225 全球芯片LOF SOXX*75%+SH516640*15%
// SH501312 海外科技LOF

class _QdiiMixAccount extends FundGroupAccount
{
    var $us_ref;
    var $cnh_ref;

    function Create()
    {
        $strCNH = 'fx_susdcnh';
        $strSymbol = $this->GetName();
        StockPrefetchExtendedData($strSymbol, $strCNH);

        $this->cnh_ref = new ForexReference($strCNH);
        $this->ref = new HoldingsReference($strSymbol);
        switch ($strSymbol)
        {
        case 'SH501225':
        	$this->us_ref = new MyStockReference('SMH');
        	break;
        	
        case 'SZ164906':
        	$this->us_ref = new HoldingsReference('KWEB');
        	break;
        	
		default:
        	$this->us_ref = false;
        	break;
        }

        $this->_updateStockHoldings($strSymbol);
        $arRef = array($this->ref);
        if ($this->us_ref)	$arRef[] = $this->us_ref; 

        GetChinaMoney($this->ref);
        SzseGetLofShares($this->ref);
        $this->CreateGroup($arRef);
    }
    
    private function _updateStockHoldings($strSymbol)
    {
    	$ref = $this->ref;
    	$strStockId = $ref->GetStockId();
    	$nav_sql = GetNavHistorySql();
    	$strNavDate = $nav_sql->GetDateNow($strStockId); 
    	
    	$date_sql = new HoldingsDateSql();
    	$strHoldingsDate = $date_sql->ReadDate($strStockId);
		if ($strNavDate == $strHoldingsDate)												return;	// Already up to date
    	if ($strHoldingsDate == $ref->GetOfficialDate())									return;
    	
    	$bUpdated = false;
    	switch ($strSymbol)
    	{
        case 'SH501225':
        case 'SH501312':
        	if ($strNavDate != $strHoldingsDate)		
        	{
        		if ($date_sql->WriteDate($strStockId, $strNavDate))		$bUpdated = true;
        	}
        	break;
		
        case 'SZ164906':
			$us_ref = $this->us_ref;
			$strUsId = $us_ref->GetStockId();
			if ($strHoldingsDate != $date_sql->ReadDate($strUsId))		$bUpdated = CopyHoldings($date_sql, $strUsId, $strStockId);
			if ($strUsNav = $nav_sql->GetClose($strUsId, $strNavDate))
			{
				$uscny_ref = $ref->GetUscnyRef();
				$fFactor = QdiiGetCalibration($strUsNav, $nav_sql->GetClose($uscny_ref->GetStockId(), $strNavDate), $nav_sql->GetClose($strStockId, $strNavDate));
				$calibration_sql = new CalibrationSql();
				$calibration_sql->WriteDaily($strStockId, $strNavDate, strval($fFactor));
			}
			break;
			
		default:
    		$fund_est_sql = $ref->GetFundEstSql();
    		$strEstDate = $fund_est_sql->GetDateNow($strStockId);
    		if ($strEstDate == $strNavDate)													return;	//
    		$strDate = $ref->GetDate();
    		if ($strEstDate == $strDate)													return;	// A day too early
    		
    		$iHourMinute = $ref->GetHourMinute();
    		if ($iHourMinute < 930)															return;	// Data not updated until 9:30
			else if ($iHourMinute > 1600 && $iHourMinute < 2230)							return;	// 美股休市后第2天的盘前，有可能会有数据看上去像休市日数据，导致5分钟一次频繁下载老文件。这里有意错过每天美股盘前时间，并且考虑了夏令时的不同最坏情况。

    		$strSymbol = $ref->GetSymbol();
    		if ($ref->IsShangHaiEtf())		$bUpdated = ReadSseHoldingsFile($strSymbol, $strStockId);
    		else if ($ref->IsShenZhenEtf())	$bUpdated = ReadSzseHoldingsFile($strSymbol, $strStockId, $strDate);
    		break;
    	}
    	
    	if ($bUpdated)
    	{
    		unset($this->ref);
    		$this->ref = new HoldingsReference($strSymbol);
//    		DebugString('Holdings updated');
    	}
    }
    
    function GetUsRef()
    {
    	return $this->us_ref;
    }
}

function _callbackQdiiMixSma($ref, $strEst = false)
{
	if ($strEst)
	{
		$uscny_ref = $ref->GetUscnyRef();
		$strStockId = $ref->GetStockId();
		$calibration_sql = new CalibrationSql();
		$strDate = $calibration_sql->GetDateNow($strStockId);
		
		$fVal = QdiiGetVal(floatval($strEst), floatval($uscny_ref->GetPrice()), floatval($calibration_sql->GetCloseNow($strStockId)));
		$fVal = FundAdjustPosition(RefGetPosition($ref), $fVal, floatval(SqlGetNavByDate($strStockId, $strDate)));
		return strval_round($fVal);
	}
	return $ref;
}

function _callbackQdiiMixTrading($strVal = false)
{
	global $acct;
    
	$us_ref = $acct->GetUsRef();
    if ($strVal)
    {
    	if ($strVal == '0')	return '';
    	else
    	{
    		$ref = $acct->GetRef();
    		$uscny_ref = $ref->GetUscnyRef();
    		$strStockId = $ref->GetStockId();
    		$calibration_sql = new CalibrationSql();
    		$strDate = $calibration_sql->GetDateNow($strStockId);
    		
    		$fVal = FundReverseAdjustPosition(RefGetPosition($ref), floatval($strVal), floatval(SqlGetNavByDate($strStockId, $strDate)));
    		$fEst = QdiiGetPeerVal($fVal, floatval($uscny_ref->GetPrice()), floatval($calibration_sql->GetCloseNow($strStockId)));
    		return $us_ref->GetPriceDisplay(strval($fEst));
    	}
    }
   	return GetTableColumnStock($us_ref).GetTableColumnPrice();
}

function EchoAll()
{
    global $acct;
    
    $ref = $acct->GetRef();
    $us_ref = $acct->GetUsRef();
    $uscny_ref = $ref->GetUscnyRef();
    $hkcny_ref = $ref->GetHkcnyRef();
    
	EchoHoldingsEstParagraph($ref);
    EchoReferenceParagraph(array_merge($acct->GetStockRefArray(), 
    									//$ref->GetHoldingRefArray(), 
    									array($acct->cnh_ref, $uscny_ref, $hkcny_ref)), $acct->IsAdmin());
    
	if ($ref->GetSymbol() == 'SZ164906')
	{
		EchoFundTradingParagraph($ref, '_callbackQdiiMixTrading');
		EchoHoldingsEstParagraph($us_ref);
		EchoSmaParagraph($us_ref, false, $ref, '_callbackQdiiMixSma');
	}
	else	
	{
		EchoFundTradingParagraph($ref);
		if ($us_ref)	EchoSmaParagraph($us_ref);
	}

    EchoFundPairHistoryParagraph($ref);
   	EchoFundShareParagraph($ref);

    if ($group = $acct->EchoTransaction()) 
    {
    	$acct->EchoMoneyParagraph($group, $uscny_ref, $hkcny_ref);
	}

    $acct->EchoLinks('qdiimix', 'GetQdiiMixLinks');
}

function GetQdiiMixLinks($sym)
{
	$str = GetSpySoftwareLinks();
	$str .= GetHSharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	return $str.GetQdiiMixRelated($sym->GetDigitA());
}

function GetMetaDescription()
{
    global $acct;

    $strDescription = $acct->GetStockDisplay();
    $str = "根据美元和港币人民币汇率中间价以及成分股比例估算{$strDescription}净值的网页工具.";
    return CheckMetaDescription($str);
}

   	$acct = new _QdiiMixAccount();
   	$acct->Create();
?>
