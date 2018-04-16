<?php
require_once('gb2312.php');
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
    	if ($this->strSqlId)	return;	// Already set, like in CnyReference
    	
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
    public static $strDataSource = STOCK_SINA_DATA;

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
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            if ($strSinaSymbol = $this->sym->GetSinaSymbol())	            $this->LoadSinaData($strSinaSymbol);
			else if ($strGoogleSymbol = $this->sym->GetGoogleSymbol())	$this->LoadGoogleData($strGoogleSymbol);
            else											                    $this->LoadYahooData();
            
/*            if ($this->bHasData == false)
            {
            	$this->bHasData = true;
                $this->LoadYahooData();
                if ($this->bHasData)	DebugString('Wrong symbol classification warning:'.$strSymbol);
            }*/
        }
        else if (self::$strDataSource == STOCK_YAHOO_DATA)
        {
            $this->LoadYahooData();
        }
        else if (self::$strDataSource == STOCK_SINA_FUTURE_DATA)
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

?>
