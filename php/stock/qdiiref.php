<?php

define('POSITION_EST_LEVEL', '4.0');

function QdiiGetCalibration($strEst, $strCNY, $strNav)
{
	return floatval($strEst) * floatval($strCNY) / floatval($strNav);
}

function QdiiGetVal($fEst, $fCny, $fFactor)
{
	return $fEst * $fCny / $fFactor;
}

function QdiiGetPeerVal($fQdii, $fCny, $fFactor)
{
	return $fQdii * $fFactor / $fCny;
}

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

// https://markets.ft.com/data/indices/tearsheet/charts?s=SPGOGUP:REU
function QdiiGetEstSymbol($strSymbol)
{
    if (in_arrayXopQdii($strSymbol))					return 'XOP';	// '^SPSIOP'
    else if ($strSymbol == 'SZ162719')   			return 'IEO'; // '^DJSOEP'
    else if ($strSymbol == 'SZ162415')   			return 'XLY';	// '^IXY'
    else if (in_arrayOilQdii($strSymbol)) 			return 'USO';
    else if ($strSymbol == 'SZ160140')   			return 'SCHH';
    else if ($strSymbol == 'SZ160416')   			return 'IXC';	// '^SPGOGUP'
    else if ($strSymbol == 'SZ161126')   			return 'XLV';
    else if (in_arrayXbiQdii($strSymbol))   			return 'XBI';
    else if ($strSymbol == 'SZ161128')   			return 'XLK';
    else if ($strSymbol == 'SZ163208')   			return 'XLE';
    else if ($strSymbol == 'SZ164824')   			return 'INDA';
    else if (in_arrayCommodityQdii($strSymbol))		return 'GSG';
    else if (in_arraySpyQdii($strSymbol))			return '^GSPC';	// 'SPY';
    else if (in_arrayQqqQdii($strSymbol))			return '^NDX';	// 'QQQ';
    else if ($strSymbol == 'SH501300')   			return 'AGG';
    else if ($strSymbol == 'SH513290')   			return 'IBB';
    else if ($strSymbol == 'SH513400')   			return '^DJI';
	else if (in_arrayGoldQdii($strSymbol))   		return 'GLD';
    else 
        return false;
}

function QdiiGetRtEtfSymbol($strSymbol)
{
    if (in_arrayOilEtfQdii($strSymbol) || in_arrayXopQdii($strSymbol))     return 'USO';
    else
    	return false;
}

function QdiiGetRealtimeSymbol($strSymbol)
{
    if (in_arrayOilEtfQdii($strSymbol) || in_arrayXopQdii($strSymbol) || in_arrayOilQdii($strSymbol))     return 'hf_CL';
    else if (in_arrayGoldQdii($strSymbol))   return 'hf_GC';
    else if (in_arraySpyQdii($strSymbol))	return 'hf_ES';
    else if (in_arrayQqqQdii($strSymbol))	return 'hf_NQ';
    else if ($strSymbol == 'SZ164824')		return 'znb_SENSEX';		
	else
	    return false;
}

function QdiiHkGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SH501025')   		 			return 'SH000869';	// '03143'
    else if (in_arrayTechQdiiHk($strSymbol))			return '^HSTECH';
    else if (in_arrayHangSengQdiiHk($strSymbol))		return '^HSI';		// '02800'
    else if (in_arrayHSharesQdiiHk($strSymbol))		return '^HSCE';	// '02828'
    else 
        return false;
}

function QdiiHkGetRealtimeSymbol($strSymbol)
{
    if (in_arrayHangSengQdiiHk($strSymbol))			return 'hf_HSI';
	else
		return false;
}

function QdiiJpGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SH513800')   		 		return 'znb_TPX';
	else if (in_arrayNkyQdiiJp($strSymbol))		return 'znb_NKY';
    else 
        return false;
}

function QdiiJpGetRealtimeSymbol($strSymbol)
{
	if (in_arrayNkyQdiiJp($strSymbol))			return 'hf_NK';
    else 
        return false;
}

function QdiiEuGetEstSymbol($strSymbol)
{
	switch ($strSymbol)
	{
	case 'SH513030':
	case 'SZ159561':
		return 'znb_DAX';
		
	case 'SH513080':
		return 'znb_CAC';
	}
	return false;
}

function QdiiEuGetRealtimeSymbol($strSymbol)
{
	return false;
}

class _QdiiReference extends FundReference
{
    var $strOfficialCNY = false;
    
    public function __construct($strSymbol, $strForex)
    {
        parent::__construct($strSymbol);
        $this->SetForex($strForex);
    }
    
    function _getEstNav($strDate)
    {
       	$est_ref = $this->GetEstRef();
		if ($str = SqlGetNavByDate($est_ref->GetStockId(), $strDate))
        {
        	return $str;
        }
        return false;
    }

    function _getEstVal($strDate)
    {
		if ($str = $this->_getEstNav($strDate))
        {
        	return $str;
        }
        
       	$est_ref = $this->GetEstRef();
        $str = $est_ref->GetPrice();
//        DebugString($est_ref->GetSymbol().' '.$str);
        if (empty($str))
        {	// SH000869 bug fix
        	$his_sql = GetStockHistorySql();
        	$str = $his_sql->GetClosePrev($est_ref->GetStockId(), $strDate);
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
			$strEstVal = $this->_getEstVal($strDate);
        	$this->fOfficialNetValue = $this->GetQdiiValue($strEstVal, $this->strOfficialCNY);
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
        
        $this->EstRealtimeNetValue();
    }

    function EstRealtimeNetValue()
    {
       	$est_ref = $this->GetEstRef();
        if ($est_ref == false)    return;
        
        $strDate = $est_ref->GetDate();
       	$cny_ref = $this->GetCnyRef();
       	if (($cny_ref->GetDate() != $this->strOfficialDate) || ($strDate != $this->strOfficialDate))
       	{
			$strEstVal = $this->_getEstVal($strDate);
        	$this->fFairNetValue = $this->GetQdiiValue($strEstVal);
       	}
        
		if ($realtime_ref = $this->GetRealtimeRef())
        {
            if ($this->rt_etf_ref == false)
            {
                $this->rt_etf_ref = $est_ref;
            }
            $realtime_ref->LoadEtfFactor($this->rt_etf_ref);
            
            $fRtEtfPrice = floatval($this->rt_etf_ref->GetPrice());
            if ($fRtEtfPrice != 0.0)
            {
            	$fRealtime = floatval($this->_getEstVal($strDate));
//            	$fVal = $realtime_ref->EstByEtf($fRtEtfPrice);
            	$fVal = $realtime_ref->EstByEtf(($this->rt_etf_ref == $est_ref) ? $fRealtime : $fRtEtfPrice);
            	if ($fVal != 0.0)
            	{
            		$fRealtime *= floatval($realtime_ref->GetPrice()) / $fVal;
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
	        	if (($strEst = $this->_getEstNav($strDate)) === false)
	        	{
//	           		if (($strEst = SqlGetHisByDate($est_ref->GetStockId(), $strDate)) === false)		return false;
	           		if (($strEst = $est_ref->GetClose($strDate)) === false)		return false;
                }
        
//                $this->fFactor = floatval($strEst) * floatval($strCNY) / floatval($this->GetPrice());
				$this->fFactor = QdiiGetCalibration($strEst, $strCNY, $this->GetPrice());
                $this->InsertFundCalibration();
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
//    		$fVal = floatval($strEst) * floatval($strCNY) / $this->fFactor;
			$fVal = QdiiGetVal(floatval($strEst), floatval($strCNY), $this->fFactor);
    		return $this->AdjustPosition($fVal);
    	}
    	return 0.0;
    }
    
    function GetEstValue($strQdii)
    {
       	$cny_ref = $this->GetCnyRef();
       	$strCNY = $cny_ref->GetPrice();
       	$fQdii = $this->ReverseAdjustPosition(floatval($strQdii));
       	return strval(QdiiGetPeerVal($fQdii, floatval($strCNY), $this->fFactor));
//        return strval($this->ReverseAdjustPosition(floatval($strQdii)) * $this->fFactor / floatval($strCNY));
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
    public function __construct($strSymbol)
    {
        parent::__construct($strSymbol, 'USCNY');
        
        if ($strEstSymbol = QdiiGetEstSymbol($strSymbol))
        {
        	$this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strRtEtfSymbol = QdiiGetRtEtfSymbol($strSymbol))
        {
            $this->rt_etf_ref = new MyStockReference($strRtEtfSymbol);
        }
        if ($strRealtimeSymbol = QdiiGetRealtimeSymbol($strSymbol))
        {
            $this->realtime_ref = StockGetReference($strRealtimeSymbol);
        }
        
        $this->EstNetValue();
    }
}

class QdiiHkReference extends _QdiiReference
{
    public function __construct($strSymbol)
    {
        parent::__construct($strSymbol, 'HKCNY');
        
        if ($strEstSymbol = QdiiHkGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strRealtimeSymbol = QdiiHkGetRealtimeSymbol($strSymbol))
        {
            $this->realtime_ref = StockGetReference($strRealtimeSymbol);
        }
        
        $this->EstNetValue();
    }
}

class QdiiJpReference extends _QdiiReference
{
    public function __construct($strSymbol)
    {
        parent::__construct($strSymbol, 'JPCNY');
        
        if ($strEstSymbol = QdiiJpGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strRealtimeSymbol = QdiiJpGetRealtimeSymbol($strSymbol))
        {
            $this->realtime_ref = StockGetReference($strRealtimeSymbol);
        }
        
        $this->EstNetValue();
    }
}

class QdiiEuReference extends _QdiiReference
{
    public function __construct($strSymbol)
    {
        parent::__construct($strSymbol, 'EUCNY');
        
        if ($strEstSymbol = QdiiEuGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strRealtimeSymbol = QdiiEuGetRealtimeSymbol($strSymbol))
        {
            $this->realtime_ref = StockGetReference($strRealtimeSymbol);
        }
        
        $this->EstNetValue();
    }
}

?>
