<?php

// ****************************** FutureReference class *******************************************************
class FutureReference extends MysqlReference
{
    function FutureReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);
    }
    
    function LoadData()
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
    		if ($this->CheckAdjustFactorTime($etf_ref))
    		{
    			$this->fFactor = floatval($this->GetPrice()) / floatval($etf_ref->GetPrice());
    			SqlInsertStockCalibration($this->strSqlId, $strEtfSymbol, $this->GetPrice(), $etf_ref->GetPrice(), $this->fFactor, $etf_ref->GetDateTime());
    		}
    		else
    		{
    			if ($fVal = SqlGetStockCalibrationFactor($this->strSqlId))
    			{
    				$this->fFactor = $fVal;
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
