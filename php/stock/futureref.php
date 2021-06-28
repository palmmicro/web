<?php

// ****************************** FutureReference class *******************************************************
class FutureReference extends MysqlReference
{
    var $calibration_sql = false;
    
    function FutureReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);

       	$this->calibration_sql = new CalibrationSql();
    }
    
    public function LoadData()
    {
        $this->LoadSinaFutureData();
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
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
    	$strEtfSymbol = $etf_ref->GetSymbol();
    	if ($strEtfSymbol == 'USO' || $strEtfSymbol == 'GLD')
    	{
    		$strEtfId = $etf_ref->GetStockId();
    		if ($this->CheckAdjustFactorTime($etf_ref))
    		{
    			$this->fFactor = floatval($this->GetPrice()) / floatval($etf_ref->GetPrice());
    			$this->calibration_sql->WriteDaily($strEtfId, $etf_ref->GetDate(), strval($this->fFactor));
    		}
    		else
    		{
    			if ($strClose = $this->calibration_sql->GetCloseNow($strEtfId))
    			{
    				$this->fFactor = floatval($strClose);
    			}
    		}
    	}
        return $this->fFactor;
    }

    function AdjustEtfFactor($etf_ref)
    {
        return false;
    }
}

?>
