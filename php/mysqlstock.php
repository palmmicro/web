<?php
require_once('gb2312.php');
require_once('stock.php');
require_once('mysqlstockhistory.php');
require_once('sql/sqlstock.php');

// ****************************** MysqlReference class *******************************************************
class MysqlReference extends StockReference
{
    var $strSqlId = false;      // ID in mysql database
    
    var $strSqlName = false;
    
    function GetStockId()
    {
        return $this->strSqlId;
    }
    
    function _loadSqlId()
    {
    	$this->strSqlId = SqlGetStockId($this->strSqlName);
        if ($this->strSqlId == false)
        {
            if ($this->bHasData)
            {
                SqlInsertStock($this->strSqlName, $this->GetEnglishName(), $this->GetChineseName());
                $this->strSqlId = SqlGetStockId($this->strSqlName);
            }
        }
    }
    
    // constructor 
    function MysqlReference($strSymbol) 
    {
        parent::StockReference($strSymbol);
        if ($this->strSqlName == false)
        {
        	$this->strSqlName = $strSymbol;
        }
        $this->_loadSqlId();
        if ($this->strSqlId)
        {
            $this->strDescription = SqlGetStockDescription($this->strSqlName);
        }
    }
}

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $iDataSource = STOCK_DATA_SINA;

    var $fFactor;

    function _loadFactor()
    {
        if ($fVal = SqlGetStockCalibrationFactor($this->strSqlId))
        {
            $this->fFactor = $fVal;
        }
        else
        {
            $this->fFactor = 1.0;
        }
        return $this->fFactor;
    }
    
    // ETF Factor functions
    function EstEtf($fVal)
    {
        return $fVal / $this->fFactor;
    }
    
    function EstByEtf($fEtf)
    {
        return $fEtf * $this->fFactor;
    }
    
    function LoadEtfFactor($etf_ref)
    {
        if ($this->AdjustEtfFactor($etf_ref) == false)
        {
            return $this->_loadFactor();
        }
        return $this->fFactor;
    }

    function AdjustEtfFactor($etf_ref)
    {
        if ($this->CheckAdjustFactorTime($etf_ref))
        {
            $this->fFactor = $this->fPrice / $etf_ref->fPrice;
            $this->InsertStockCalibration($etf_ref);
            return true;
        }
        return false;
    }

    function InsertStockCalibration($etf_ref)
    {
        return SqlInsertStockCalibration($this->strSqlId, $etf_ref->GetStockSymbol(), $this->strPrice, $etf_ref->strPrice, $this->fFactor, $etf_ref->GetDateTime());
    }

    // Future Factor functions
    function EstByFuture($fEtf, $fCNY)
    {
        return $fEtf * $fCNY / $this->fFactor;
    }
    
    function LoadFutureFactor($future_ref, $strForexSqlId)
    {
        if ($this->AdjustFutureFactor($future_ref, $strForexSqlId) == false)
        {
            $this->_loadFactor();
        }
        return $this->fFactor;
    }
    
    function AdjustFutureFactor($future_ref, $strForexSqlId)
    {
        if ($this->bHasData == false)    return false;
        
        $fCNY = SqlGetForexCloseHistory($strForexSqlId, $this->strDate);
        if ($fCNY)
        {
            if ($this->CheckAdjustFactorTime($future_ref))
            {
                $this->fFactor = $future_ref->fPrice * $fCNY / $this->fPrice;
                $this->InsertStockCalibration($future_ref);
                return true;
            }
        }
        return false;
    }
    
    function _invalidHistoryData($str)
    {
//        if (empty($str))    return true;
        if ($str == 'N/A')   return true;
        if (FloatNotZero(floatval($str)) == false)  return true;
        return false;
    }
    
    function _updateStockHistory()
    {
        if ($this->bHasData == false)   return false;
        
        $strStockId = $this->strSqlId;
        $strDate = $this->strDate;
        $strOpen = $this->strOpen;
        $strHigh = $this->strHigh;
        $strLow = $this->strLow;
        $strClose = $this->strPrice;
        $strVolume = $this->strVolume;
        if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
        {
//            if ($this->_invalidHistoryData($strOpen))   return false;
//            if ($this->_invalidHistoryData($strHigh))   return false;
//            if ($this->_invalidHistoryData($strLow))    return false;
            if ($this->_invalidHistoryData($strClose))  return false;
            return SqlUpdateStockHistory($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strClose);
        }
        else
        {
            return SqlInsertStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strClose);
        }
        return false;
    }
    
    // constructor 
    function MyStockReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        if (self::$iDataSource == STOCK_DATA_SINA)
        {
            if ($strSinaSymbol = $this->sym->GetSinaSymbol())
            {
                $this->LoadSinaData($strSinaSymbol);
            }
            else
            {
                if ($strGoogleSymbol = $this->sym->GetGoogleSymbol())
                {
                    $this->LoadGoogleData($strGoogleSymbol);
                }
                else
                {
                    $this->LoadYahooData();
                }
            }
        }
        else if (self::$iDataSource == STOCK_DATA_YAHOO)
        {
            $this->LoadYahooData();
        }
        else if (self::$iDataSource == FUTURE_DATA_SINA)
        {
            $this->strSqlName = FutureGetSinaSymbol($strSymbol);
            $this->LoadSinaFutureData($strSymbol);
        }
        
        parent::MysqlReference($strSymbol);
        if ($this->strSqlId)
        {
            $this->_updateStockHistory();
        }
    }
}

function _getEtfLeverageRatio($strSymbol)
{
    if ($strSymbol == 'SH')         return -1.0;
    else if ($strSymbol == 'VXX')  return 0.5;      // compare with UVXY
    else if ($strSymbol == 'SVXY')  return -0.5;    // compare with UVXY
    else if ($strSymbol == 'DGP' || $strSymbol == 'AGQ' || $strSymbol == 'UCO')   return 2.0;
    else if ($strSymbol == 'SDS' || $strSymbol == 'DZZ' || $strSymbol == 'ZSL' || $strSymbol == 'SCO')  return -2.0;
    else if ($strSymbol == 'GUSH' || $strSymbol == 'UWT' || $strSymbol == 'UPRO' || $strSymbol == 'UGAZ')  return 3.0;
    else if ($strSymbol == 'DRIP' || $strSymbol == 'DWT' || $strSymbol == 'SPXU' || $strSymbol == 'DGAZ')  return -3.0;
    else if ($strSymbol == 'WB')  return 1.46;      // compare with SINA
    else 
        return 1.0;
}

class MyLeverageReference extends MyStockReference
{
    var $fRatio;
    
    // constructor 
    function MyLeverageReference($strSymbol) 
    {
        $this->fRatio = _getEtfLeverageRatio($strSymbol);
        parent::MyStockReference($strSymbol);
    }

    function EstByEtf1x($fEtf1x, $ref_1x)
    {
        $fGain1x = ($fEtf1x / $ref_1x->fPrevPrice) - 1.0;
        return (1.0 + $this->fRatio * $fGain1x) * $this->fPrevPrice; 
    }
    
    function GetEstByEtf1xDisplay($fEtf1x, $ref_1x)
    {
        $fVal = $this->EstByEtf1x($fEtf1x, $ref_1x);
        return $this->GetPriceDisplay($fVal);
    }
}

class MyYahooStockReference extends MyStockReference
{
    // constructor 
    function MyYahooStockReference($strSymbol) 
    {
        $iBackup = parent::$iDataSource;
        parent::$iDataSource = STOCK_DATA_YAHOO;
        parent::MyStockReference($strSymbol);
        parent::$iDataSource = $iBackup;
    }
}

class MyFutureReference extends MyStockReference
{
    // constructor 
    function MyFutureReference($strSymbol) 
    {
        $iBackup = parent::$iDataSource;
        parent::$iDataSource = FUTURE_DATA_SINA;
        parent::MyStockReference($strSymbol);
        parent::$iDataSource = $iBackup;
    }
}

class MyHShareReference extends MyStockReference
{
    var $a_ref;

    var $fRatio = 1.0;
    var $fHKDCNY;
    
    // constructor 
    function MyHShareReference($strSymbol, $a_ref) 
    {
    	$this->a_ref = $a_ref;
    	if ($a_ref)
    	{
    		$this->fRatio = SqlGetAhPairRatio($a_ref);
    	}
    	$this->fHKDCNY = SqlGetHKCNY();
        parent::MyStockReference($strSymbol);
    }
    
    function EstFromCny($fEst)
    {
    	return $fEst / ($this->fRatio * $this->fHKDCNY);
    }

    function EstToCny($fEst)
    {
    	return $fEst * ($this->fRatio * $this->fHKDCNY);
    }
    
    function GetCnyPrice()
    {
    	return $this->EstToCny($this->fPrice);
    }
    
    function GetAhRatio()
    {
    	if ($this->a_ref)
    	{
    		return $this->a_ref->fPrice / $this->GetCnyPrice();
    	}
    	return 1.0;
    }
}

class MyHAdrReference extends MyHShareReference
{
    var $adr_ref;

    var $fAdrRatio = 1.0;
    var $fHKDUSD;
    var $fUSDCNY;
    
    // constructor 
    function MyHAdrReference($strSymbol, $a_ref, $adr_ref) 
    {
    	$this->adr_ref = $adr_ref;
    	if ($adr_ref)
    	{
    		$this->fAdrRatio = SqlGetAdrhPairRatio($adr_ref);
    	}
    	$this->fUSDCNY = SqlGetUSCNY();
        parent::MyHShareReference($strSymbol, $a_ref);
        $this->fHKDUSD = $this->fHKDCNY / $this->fUSDCNY;
    }
    
    function EstFromUsd($fEst)
    {
    	return $fEst / ($this->fAdrRatio * $this->fHKDUSD);
    }

    function EstToUsd($fEst)
    {
    	return $fEst * ($this->fAdrRatio * $this->fHKDUSD);
    }
    
    function FromUsdToCny($fEst)
    {
		$fHkd = $this->EstFromUsd($fEst);
		return $this->EstToCny($fHkd);
	}

	function FromCnyToUsd($fEst, $ref)
	{
		$fHkd = $this->EstFromCny($fEst);
		return $this->EstToUsd($fHkd);
	}
    
    function GetUsdPrice()
    {
    	return $this->EstToUsd($this->fPrice);
    }
    
    function GetAdrhRatio()
    {
    	if ($this->adr_ref)
    	{
    		return $this->adr_ref->fPrice / $this->GetUsdPrice();
    	}
    	return 1.0;
    }
}

// ****************************** MyFundReference class *******************************************************

define ('FUND_POSITION_RATIO', 0.95);
define ('FUND_EMPTY_NET_VALUE', '0');

function GetEstErrorPercentage($fEstValue, $fNetValue)
{
    if (abs($fEstValue - $fNetValue) < 0.0005)
    {
        $fPercentage = 0.0;
    }
    else
    {
        $fPercentage = StockGetPercentage($fEstValue, $fNetValue);
    }
    return $fPercentage;
}

class MyFundReference extends FundReference
{
    var $est_ref = false;       // MyStockRefenrence for fund net value estimation
    var $stock_ref = false;     // MyStockReference
    var $index_ref = false;
    var $etf_ref = false;
    var $future_ref = false;
    var $future_etf_ref = false;

    // estimated float point data 
    var $fRealtimeNetValue = false;
    var $fFairNetValue = false;

    var $strOfficialDate = false;
    
    var $fFactor = 1.0;
    
    var $strForexSymbol;
    var $strForexSqlId;
    
    function SetForex($strForex)
    {
        $this->strForexSymbol = $strForex;
        $this->strForexSqlId = SqlGetStockId($this->strForexSymbol);
    }

    function GetForexNow()
    {
        return SqlGetForexNow($this->strForexSqlId);
    }
    
    // Update database
    function UpdateEstNetValue()
    {
        $strSqlId = $this->GetStockId();
        $strDate = $this->est_ref->strDate;
        list($strDummy, $strTime) = explodeDebugDateTime();
        $strPrice = strval($this->fPrice);
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['netvalue'] == FUND_EMPTY_NET_VALUE)
            {   // Only update when official net value is not ready
                SqlUpdateFundHistory($history['id'], FUND_EMPTY_NET_VALUE, $strPrice, $strTime);
            }
        }
        else
        {
            SqlInsertFundHistory($strSqlId, $strDate, FUND_EMPTY_NET_VALUE, $strPrice, $strTime);
        }
    }

    function _compareEstResult($strNetValue, $strEstValue)
    {
        $fPercentage = GetEstErrorPercentage(floatval($strEstValue), floatval($strNetValue));
        if (abs($fPercentage) > 1.0)
        {
            $strSymbol = $this->GetStockSymbol();
            $strLink = GetNetValueHistoryLink($strSymbol, true);
            $str = sprintf('%s%s 实际值%s 估值%s 误差:%.2f%%, 从_compareEstResult函数调用.', $strSymbol, $strLink, $strNetValue, $strEstValue, $fPercentage); 
            EmailDebug($str, 'Netvalue estimation error');
        }
    }
    
    function UpdateOfficialNetValue()
    {
        $strDate = $this->strDate;
        $ymd = new YMDString($strDate);
        if ($ymd->IsWeekend())     return false;   // sina fund may provide wrong weekend data

        $strSqlId = $this->GetStockId();
        $strNetValue = $this->strPrevPrice;
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['netvalue'] == FUND_EMPTY_NET_VALUE)
            {
                $strEstValue = $history['estimated'];
                SqlUpdateFundHistory($history['id'], $strNetValue, $strEstValue, $history['time']);
                $this->_compareEstResult($strNetValue, $strEstValue);
            }
            else
            {
                return false;
            }
        }
        else
        {
            SqlInsertFundHistory($strSqlId, $strDate, $strNetValue, '0', '0');
        }
        return true;
    }

    function InsertFundCalibration($est_ref, $strEstPrice)
    {
        return SqlInsertStockCalibration($this->GetStockId(), $est_ref->GetStockSymbol(), $this->strPrevPrice, $strEstPrice, $this->fFactor, DebugGetTimeDisplay());
    }

    function GetStockSymbol()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetStockSymbol();
        }
        return parent::GetStockSymbol();
    }

    function GetStockId()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetStockId();
        }
        return false;
    }
    
    // constructor 
    function MyFundReference($strSymbol)
    {
        parent::FundReference($strSymbol);

        if ($this->sym->IsFundA())
        {
            $this->stock_ref = new MyStockReference($strSymbol);
        }
        if ($strStockId = $this->GetStockId())
        {
        	if ($fVal = SqlGetStockCalibrationFactor($strStockId))		$this->fFactor = $fVal; 
        }
    }

    function AdjustPosition($fVal)
    {
        return $fVal * FUND_POSITION_RATIO + $this->fPrevPrice * (1.0 - FUND_POSITION_RATIO);
    }
}

// ****************************** MyCnyReference class *******************************************************
class MyCnyReference extends MysqlReference
{
	function _updateHistory()
	{
		if (FloatNotZero(floatval($this->strOpen)) == false)
		{
			$this->EmptyFile();
			return;
		}
    
		if (SqlGetForexHistory($this->strSqlId, $this->strDate) == false)
		{
			SqlInsertForexHistory($this->strSqlId, $this->strDate, $this->strPrice);
		}    
	}

    // constructor 
    function MyCnyReference($strSymbol)
    {
    	$this->LoadEastMoneyCnyData($strSymbol);
        parent::MysqlReference($strSymbol);
        if ($this->strSqlId)
        {
        	$this->_updateHistory();
        }
    }       
}

// ****************************** MyCnyReference class *******************************************************
class MyForexReference extends MysqlReference
{
    public static $iDataSource = STOCK_DATA_SINA;
//    public static $iDataSource = STOCK_DATA_EASTMONEY;

    // constructor 
    function MyForexReference($strSymbol)
    {
        if (self::$iDataSource == STOCK_DATA_SINA)
        {
            $this->LoadSinaForexData($strSymbol);
        }
        else
        {
            $this->LoadEastMoneyForexData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
    }       
}

// ****************************** StockTransaction class related *******************************************************

class MyStockTransaction extends StockTransaction
{
    var $ref;                       // MyStockReference
    var $strStockGroupItemId;
    
    // constructor 
    function MyStockTransaction($ref, $strStockGroupId) 
    {
        $this->ref = $ref;
        if ($strStockGroupId)
        {
            if ($ref)   $this->strStockGroupItemId = SqlGetStockGroupItemId($strStockGroupId, $ref->GetStockId());
        }
        parent::StockTransaction();
    }

    function GetStockSymbol()
    {
        if ($this->ref)
        {
            return $this->ref->GetStockSymbol();
        }
        return false;
    }
    
    function GetAvgCostDisplay()
    {
        if ($this->ref)     return $this->ref->GetPriceDisplay($this->GetAvgCost());
        return '';
    }
    
    function GetValue()
    {
        if ($this->ref)     return $this->iTotalShares * $this->ref->fPrice;
        return 0.0;
    }

    function GetValueDisplay()
    {
        return GetNumberDisplay($this->GetValue());
    }
    
    function GetProfit()
    {
        return $this->GetValue() - $this->fTotalCost;
    }
    
    function GetProfitDisplay()
    {
        return GetNumberDisplay($this->GetProfit());
    }
}

// ****************************** StockGroup class related *******************************************************

class MyStockGroup extends StockGroup
{
    var $strGroupId;
    
    var $arStockTransaction = array();
    
    var $arbi_trans;
    var $bCountArbitrage;
    
    function GetStockTransactionByStockGroupItemId($strStockGroupItemId)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->strStockGroupItemId == $strStockGroupItemId)     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionByStockId($strStockId)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->GetStockId() == $strStockId)     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionBySymbol($strSymbol)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)   return $trans;
        }
        return false;
    }
    
    function GetStockTransactionCN()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolA())     return $trans;
        }
        return false;
    }

    function GetStockTransactionHK()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolH())     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionUS()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolUS())     return $trans;
        }
        return false;
    }
    
    function _addTransaction($ref)
    {
        $this->arStockTransaction[] = new MyStockTransaction($ref, $this->strGroupId);
    }
    
    function _checkSymbol($strSymbol)
    {
        if ($this->GetStockTransactionBySymbol($strSymbol))  return;
        
        $this->_addTransaction(new MyStockReference($strSymbol));
    }
        
    function AddTransaction($strSymbol, $iShares, $fCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)
            {
                $trans->AddTransaction($iShares, $fCost);
                break;
            }
        }
    }

    function SetValue($strSymbol, $iTotalRecords, $iTotalShares, $fTotalCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)
            {
                $trans->SetValue($iTotalRecords, $iTotalShares, $fTotalCost);
                $this->OnStockTransaction($trans);
                break;
            }
        }
    }

    function GetTotalRecords()
    {
        $iTotal = 0;
        foreach ($this->arStockTransaction as $trans)
        {
            $iTotal += $trans->iTotalRecords;
        }
        return $iTotal;
    }
    
    function _checkArbitrage($strSymbol)
    {
        if ($this->arbi_trans)
        {
            if ($this->arbi_trans->GetStockSymbol() != $strSymbol)
            {
                $this->bCountArbitrage = false;
            }
        }
        else
        {
            $trans = $this->GetStockTransactionBySymbol($strSymbol);
            if ($trans)
            {
                $this->arbi_trans = new MyStockTransaction($trans->ref, $this->strGroupId);
                $this->bCountArbitrage = true;
            }
        }
    }
    
    function _onArbitrageTransaction($strSymbol, $transaction)
    {
        $this->_checkArbitrage($strSymbol);
        if ($this->bCountArbitrage)
        {
            AddSqlTransaction($this->arbi_trans, $transaction);
            return true;
        }
        return false;
    }
    
    function OnArbitrage()
    {
        $strGroupId = $this->strGroupId;
        if ($result = SqlGetStockTransactionByGroupId($strGroupId, 0, 0)) 
        {   
            $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($strGroupId);
            while ($transaction = mysql_fetch_assoc($result)) 
            {
                $strSymbol = $arGroupItemSymbol[$transaction['groupitem_id']];
                if ($this->_onArbitrageTransaction($strSymbol, $transaction) == false)  break;
            }
            @mysql_free_result($result);
        }
    }
    
    // constructor 
    function MyStockGroup($strGroupId, $arRef) 
    {
        $this->strGroupId = $strGroupId;
        $this->arbi_trans = false;
        
        foreach ($arRef as $ref)
        {
            $this->_addTransaction($ref);
        }
        parent::StockGroup();
        
        if ($result = SqlGetStockGroupItemByGroupId($strGroupId)) 
        {   
            while ($groupitem = mysql_fetch_assoc($result)) 
            {
                if (intval($groupitem['record']) > 0)
                {
                    $this->SetValue(SqlGetStockSymbol($groupitem['stock_id']), intval($groupitem['record']), intval($groupitem['quantity']), floatval($groupitem['cost']));
                }
            }
            @mysql_free_result($result);
        }
    }
}

// ****************************** General functions related with Sql and stock *******************************************************

function _sqlMergeStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
{
    if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
    {
        SqlUpdateStockHistory($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
    else
    {
        SqlInsertStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
}

/*
function _getHistoryQuotesYMD($str)
{
    $arLines = explode("\n", $str, 3);
    $arWords = explode(',', $arLines[1], 2);
//    return explode('-', $arWords[0]);
    return $arWords[0];
}

function _getPastQuotes($sym, $strFileName)
{
    if (($str = IsNewDailyQuotes($sym, $strFileName, false, _getHistoryQuotesYMD)) === false)
    {
        $str = GetYahooPastQuotes($sym->GetYahooSymbol(), MAX_QUOTES_DAYS);
        file_put_contents($strFileName, $str);
    }
    return $str;
}

function _oldUpdateYahooHistory($strStockId, $sym)
{
    $strSymbol = $sym->strSymbol;
    $strFileName = DebugGetYahooHistoryFileName($strSymbol);
    $str = _getPastQuotes($sym, $strFileName);
    if (IsYahooStrError($str))
    {
        DebugString('IsYahooStrError returned ture with symbol - '.$strSymbol);
        return;
    }

    DebugString('StockUpdateYahooHistory with symbol - '.$strSymbol);
    $arYahoo = explode("\n", $str);
    foreach ($arYahoo as $strLine)
    {
        $ar = explode(',', $strLine);
//        DebugString($ar[0].' '.$ar[1].' '.$ar[2].' '.$ar[3].' '.$ar[4].' '.$ar[5].' '.$ar[6]);
        $strDate = $ar[0];
        if ((!empty($strDate)) && ($strDate != 'Date'))
        {
            _sqlMergeStockHistory($strStockId, $strDate, $ar[1], $ar[2], $ar[3], $ar[4], $ar[5], $ar[6]);
        }
    }
}
*/

function _webUpdateYahooHistory($strStockId, $sym)
{
    $strSymbol = $sym->GetYahooSymbol();
    $sym->SetTimeZone();
    $iTime = time();

    $iTotal = 0;
    $iMax = 100;
    $iMaxSeconds = $iMax * SECONDS_IN_DAY;
    for ($k = 0; $k < MAX_QUOTES_DAYS; $k += $iMax)
    {
        $iTimeBegin = $iTime - $iMaxSeconds;
        $str = YahooGetStockHistory($strSymbol, $iTimeBegin, $iTime);

        $arMatch = preg_match_yahoo_history($str);
        $iVal = count($arMatch);
        $iTotal += $iVal;
        if ($iVal < $iMax / 2)
        {
            $ymd_begin = new YMDTick($iTimeBegin);
            $ymd = new YMDTick($iTime);
            DebugString(sprintf('_webUpdateYahooHistory %s %d from %s to %s', $strSymbol, $iVal, $ymd_begin->GetYMD(), $ymd->GetYMD()));
        }
        
        for ($j = 0; $j < $iVal; $j ++)
        {
            $ymd = new YMDTick(strtotime($arMatch[$j][1]));
            $strDate = $ymd->GetYMD();
            
            $ar = array();
            $str = $strDate;
            for ($i = 0; $i < 6; $i ++)
            {
                $strNoComma = str_replace(',', '', $arMatch[$j][$i + 2]); 
                $ar[] = $strNoComma;
                $str .= ' '.$strNoComma; 
            }
            _sqlMergeStockHistory($strStockId, $strDate, $ar[0], $ar[1], $ar[2], $ar[3], $ar[5], $ar[4]);
        }
        $iTime = $iTimeBegin;
    }
    DebugString(sprintf('_webUpdateYahooHistory %s total %d', $strSymbol, $iTotal));
}

function StockUpdateYahooHistory($strStockId, $strSymbol)
{
    if (AcctIsAdmin() == false)     return;
    
    unlinkEmptyFile(DebugGetConfigFileName($strSymbol));
    
    $sym = new StockSymbol($strSymbol);
//    _oldUpdateYahooHistory($strStockId, $sym);
    _webUpdateYahooHistory($strStockId, $sym);
    
    if ($sym->IsSymbolA() || $sym->IsSymbolH())
    {   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
        if ($sym->IsIndex() == false)
        {
            SqlDeleteStockHistoryWithZeroVolume($strStockId);
        }
    }
}

function StockGroupItemTransactionUpdate($strStockGroupItemId)
{
    $trans = new StockTransaction();
    if ($result = SqlGetStockTransactionByGroupItemId($strStockGroupItemId, 0, 0)) 
    {
        while ($transaction = mysql_fetch_assoc($result)) 
        {
            AddSqlTransaction($trans, $transaction);
        }
        @mysql_free_result($result);
    }
    SqlUpdateStockGroupItem($strStockGroupItemId, strval($trans->iTotalShares), strval($trans->fTotalCost), strval($trans->iTotalRecords));
}

/*
function StockGroupItemUpdateAll()
{
    if ($result = SqlGetTableData(TABLE_STOCK_GROUP_ITEM, false, false, false)) 
    {
        while ($item = mysql_fetch_assoc($result)) 
        {
            StockGroupItemTransactionUpdate($item['id']);
        }
        @mysql_free_result($result);
    }
}
*/

function StockGroupItemUpdate($strGroupItemId)
{
    $groupitem = SqlGetStockGroupItemById($strGroupItemId);
	if ($result = SqlGetStockGroupItemByGroupId($groupitem['group_id']))
	{
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    StockGroupItemTransactionUpdate($stockgroupitem['id']);
		}
		@mysql_free_result($result);
	}
}

function StockGetIdSymbolArray($strSymbols)
{
	$arIdSymbol = array();
    $arSymbol = StockGetSymbolArray($strSymbols);
	foreach ($arSymbol as $strSymbol)
	{
	    $strStockId = SqlGetStockId($strSymbol);
	    if ($strStockId == false)
	    {
            $ref = MyStockGetReference(new StockSymbol($strSymbol));
            if ($ref->bHasData)
            {
            	$strStockId = $ref->GetStockId();
            }
            else
            {
            	continue;
            }
	    }
	    $arIdSymbol[$strStockId] = $strSymbol; 
	}
	return $arIdSymbol;
}

function StockInsertGroup($strMemberId, $strGroupName, $strStocks)
{
    SqlInsertStockGroup($strMemberId, $strGroupName);
    $strGroupId = SqlGetStockGroupId($strGroupName, $strMemberId);
    
    if ($strGroupId)
    {
        $arIdSymbol = StockGetIdSymbolArray($strStocks);
        foreach ($arIdSymbol as $strStockId => $strSymbol)
        {
	        SqlInsertStockGroupItem($strGroupId, $strStockId);
        }
    }
    
    return $strGroupId;
}

?>
