<?php

define('POSITION_EST_LEVEL', '4.0');

// (est * cny / estPrev * cnyPrev - 1) * position = (nv / nvPrev - 1) 
function QdiiGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny, $strInput = POSITION_EST_LEVEL)
{
	$fEst = StockGetPercentage($strEstPrev, $strEst);
	if (($fEst !== false) && (abs($fEst) > floatval($strInput)))
	{
		$f = StockGetPercentage(strval(floatval($strEstPrev) * floatval($strCnyPrev)), strval(floatval($strEst) * floatval($strCny)));
		if (($f !== false) && ($f != 0.0))
		{
			$fVal = StockGetPercentage($strPrev, $strNetValue) / $f;
			if ($fVal > 0.1)
			{
				return strval_round($fVal, 2);
			}
		}
	}
	return false;
}

function QdiiGetStockCalibration($strEst, $strNetValue, $strCny, $strPosition)
{
	$fDivisor = floatval($strNetValue) * floatval($strPosition);
	if ($fDivisor == 0.0)
	{
		return '0';
	}
	return strval(intval(floatval($strCny) * floatval($strEst) / $fDivisor, 0));
}

// https://markets.ft.com/data/indices/tearsheet/charts?s=SPGOGUP:REU
function QdiiGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SZ162411')         return 'XOP';	// '^SPSIOP'
    else if ($strSymbol == 'SZ162719')   return 'IEO'; // '^DJSOEP'
    else if ($strSymbol == 'SZ162415')   return 'XLY';	// '^IXY'
    else if (in_arrayOilQdii($strSymbol)) return 'USO';
    else if ($strSymbol == 'SZ160140')   return 'SCHH';
    else if ($strSymbol == 'SZ160416')   return 'IXC';	// '^SPGOGUP'
    else if ($strSymbol == 'SZ161126')   return 'XLV';
    else if ($strSymbol == 'SZ161127')   return 'XBI';
    else if ($strSymbol == 'SZ161128')   return 'XLK';
    else if ($strSymbol == 'SZ163208')   return 'XLE';
    else if ($strSymbol == 'SZ164824')   return 'INDA';
    else if ($strSymbol == 'SZ164906')   return 'KWEB';
    else if ($strSymbol == 'SZ165510')	return 'BKF';	// '^SPBRICNTR'
    else if (in_arrayCommodityQdii($strSymbol))		return 'GSG';
    else if (in_arraySpyQdii($strSymbol))				return '^GSPC';	// 'SPY';
    else if (in_arrayQqqQdii($strSymbol))				return '^NDX';	// 'QQQ';
    else if ($strSymbol == 'SH513030')   return 'DAX';		// 'EWG'
    else if (in_arrayGoldQdii($strSymbol))   return 'GLD';
    else 
        return false;
}

function QdiiGetFutureEtfSymbol($strSymbol)
{
    if (in_arrayOilEtfQdii($strSymbol))     return 'USO';
    return false;
}

function QdiiGetFutureSymbol($strSymbol)
{
    if (in_arrayOilEtfQdii($strSymbol) || in_arrayOilQdii($strSymbol))     return 'hf_CL';
    else if (in_arrayGoldQdii($strSymbol))   return 'hf_GC';
    else if (in_arraySpyQdii($strSymbol))   return 'hf_ES';
    else if (in_arrayQqqQdii($strSymbol))   return 'hf_NQ';
    
    return false;
}

function QdiiGetAllSymbolArray($strSymbol)
{
    $ar = array();
    
    $ar[] = $strSymbol; 
    if ($strEstSymbol = QdiiGetEstSymbol($strSymbol))
    {
        $ar[] = $strEstSymbol; 
    }
    if ($strFutureSymbol = QdiiGetFutureSymbol($strSymbol))
    {
        $ar[] = $strFutureSymbol; 
    }
    if ($strFutureEtfSymbol = QdiiGetFutureEtfSymbol($strSymbol))
    {
        $ar[] = $strFutureEtfSymbol; 
    }
    return $ar;
}

function QdiiHkGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SH501025')   		 		return 'SH000869';	// '03143'
    else if (in_arrayHangSengQdiiHk($strSymbol))	return '^HSI';		// '02800'
    else if (in_arrayHSharesQdiiHk($strSymbol))	return '^HSCE';	// '02828'
    else 
        return false;
}

function QdiiHkGetAllSymbolArray($strSymbol)
{
    $ar = array();
    
    $ar[] = $strSymbol; 
    if ($strEstSymbol = QdiiHkGetEstSymbol($strSymbol))
    {
        $ar[] = $strEstSymbol; 
    }
    return $ar;
}

class _QdiiReference extends FundReference
{
    var $strOfficialCNY = false;
    
    function _QdiiReference($strSymbol, $strForex)
    {
        parent::FundReference($strSymbol);
        $this->SetForex($strForex);
    }
    
    function _getEstVal()
    {
       	$est_ref = $this->GetEstRef();
       	$strDate = $est_ref->GetDate();
       	$strStockId = $est_ref->GetStockId();
		if ($str = SqlGetNavByDate($strStockId, $strDate))
        {
        	return $str;
        }
        $str = $est_ref->GetPrice();
//        DebugString($est_ref->GetSymbol().' '.$str, true);
        if (empty($str))
        {	// SH000869 bug fix
        	$his_sql = GetStockHistorySql();
        	$str = $his_sql->GetClosePrev($strStockId, $strDate);
        }
        return $str;
    }

    function EstNetValue()
    {
		$this->AdjustFactor();
        
       	$cny_ref = $this->GetCnyRef();
       	$est_ref = $this->GetEstRef();
        if ($est_ref == false)    return;
        
        $strDate = $est_ref->GetDate();
        if ($this->strOfficialCNY = $cny_ref->GetClose($strDate))
        {
			if (method_exists($est_ref, 'GetOfficialNav'))
        	{	// KWEB as $est_ref
        		$this->fOfficialNetValue = $this->GetQdiiValue(strval($est_ref->GetOfficialNav()), $this->strOfficialCNY);
        	}
        	else	$this->fOfficialNetValue = $this->GetQdiiValue($this->_getEstVal(), $this->strOfficialCNY);
            $this->strOfficialDate = $strDate;
            $this->UpdateEstNetValue();
        }
        else
        {   // Load last value from database
			$fund_est_sql = $this->GetFundEstSql();
            if ($record = $fund_est_sql->GetRecordNow($this->GetStockId()))
            {
                $this->fOfficialNetValue = floatval($record['close']);
                $this->strOfficialDate = $record['date'];
                $this->strOfficialCNY = $cny_ref->GetClose($this->strOfficialDate);
            }
            else
            {
                $this->strOfficialCNY = $cny_ref->GetPrice();
            }
        }
    }

    function EstRealtimeNetValue()
    {
       	$est_ref = $this->GetEstRef();
        if ($est_ref == false)    return;
        
       	$cny_ref = $this->GetCnyRef();
       	if (($cny_ref->GetDate() != $this->strOfficialDate) || ($est_ref->GetDate() != $this->strOfficialDate))
       	{
			if (method_exists($est_ref, 'GetFairNav'))
        	{
        		$this->fFairNetValue = $this->GetQdiiValue(strval($est_ref->GetFairNav()));
        	}
        	else	$this->fFairNetValue = $this->GetQdiiValue($this->_getEstVal());
       	}
        
		if ($future_ref = $this->GetFutureRef())
        {
            if ($this->future_etf_ref == false)
            {
                $this->future_etf_ref = $est_ref;
            }
            $future_ref->LoadEtfFactor($this->future_etf_ref);
            
            $fFutureEtfPrice = floatval($this->future_etf_ref->GetPrice());
            if ($fFutureEtfPrice != 0.0)
            {
            	$fRealtime = floatval($this->_getEstVal());
            	$fFuture = $future_ref->EstByEtf($fFutureEtfPrice);
            	if ($fFuture != 0.0)
            	{
            		$fRealtime *= floatval($future_ref->GetPrice()) / $fFuture;
            	}
            	$this->fRealtimeNetValue = $this->GetQdiiValue(strval($fRealtime));
            }
        }
    }

    function AdjustFactor()
    {
        if ($this->UpdateOfficialNetValue())
        {
            $strDate = $this->GetDate();
	       	$cny_ref = $this->GetCnyRef();
            if ($strCNY = $cny_ref->GetClose($strDate))
            {
            	$est_ref = $this->GetEstRef();
                if (RefHasData($est_ref) == false)    return false;
                
                if ($strEst = SqlGetNavByDate($est_ref->GetStockId(), $strDate))
                {
                }
                else
                {
                	if (method_exists($est_ref, 'GetOfficialNav'))
                	{	// KWEB as $est_ref
                		$strEst = strval($est_ref->GetOfficialNav());
                		DebugString('Used KWEB officical nav est in AdjustFactor');
                	}
                	else
                	{
                		$strEstDate = $est_ref->GetDate();
                		$est_ymd = new StringYMD($strEstDate);
                		$ymd = new StringYMD($strDate);
               	
                		if ($strDate == $strEstDate)	                   					$strEst = $est_ref->GetPrice();
                		else if ($ymd->GetNextTradingDayTick() == $est_ymd->GetTick())		$strEst = $est_ref->GetPrevPrice();
                		else	return false;
                	}
                }
        
                $this->fFactor = floatval($strEst) * floatval($strCNY) / floatval($this->GetPrice());
                $this->InsertFundCalibration($est_ref, $strEst);
                return $this->fFactor;
            }
        }
        return false;
    }

    function GetQdiiValue($strEst, $strCNY = false)
    {
    	if ($strCNY == false)
    	{
	       	$cny_ref = $this->GetCnyRef();
	       	$strCNY = $cny_ref->GetPrice();
    	}
    	
    	if ($this->fFactor)
    	{
    		$fVal = floatval($strEst) * floatval($strCNY) / $this->fFactor;
    		return $this->AdjustPosition($fVal);
    	}
    	return 0.0;
    }
    
    function GetEstValue($strQdii)
    {
       	$cny_ref = $this->GetCnyRef();
       	$strCNY = $cny_ref->GetPrice();
        return strval($this->ReverseAdjustPosition(floatval($strQdii)) * $this->fFactor / floatval($strCNY));
    }
    
    function GetEstQuantity($iQdiiQuantity)
    {
        return intval($iQdiiQuantity / $this->fFactor);
    }

    function GetQdiiQuantity($iEstQuantity)
    {
        return intval($iEstQuantity * $this->fFactor);
    }
}

class QdiiReference extends _QdiiReference
{
    function QdiiReference($strSymbol)
    {
        parent::_QdiiReference($strSymbol, 'USCNY');
        
        if ($strEstSymbol = QdiiGetEstSymbol($strSymbol))
        {
        	if ($strSymbol == 'SZ164906')		$this->est_ref = new EtfHoldingsReference($strEstSymbol);
        	else				        		$this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strFutureEtfSymbol = QdiiGetFutureEtfSymbol($strSymbol))
        {
            $this->future_etf_ref = new MyStockReference($strFutureEtfSymbol);
        }
        if ($strFutureSymbol = QdiiGetFutureSymbol($strSymbol))
        {
            $this->future_ref = new FutureReference($strFutureSymbol);
        }
        
        $this->EstNetValue();
        $this->EstRealtimeNetValue();
    }
}

class QdiiHkReference extends _QdiiReference
{
    function QdiiHkReference($strSymbol)
    {
        parent::_QdiiReference($strSymbol, 'HKCNY');
        
        if ($strEstSymbol = QdiiHkGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        $this->EstNetValue();
        $this->EstRealtimeNetValue();
    }
}

?>
