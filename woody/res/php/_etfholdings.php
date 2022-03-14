<?php
require_once('/php/gb2312.php');
require_once('_holdingscsvfile.php');

class _EtfHoldingsFile extends _HoldingsCsvFile
{
    var $fCash;
	
    function _EtfHoldingsFile($strDebug, $strStockId) 
    {
        parent::_HoldingsCsvFile($strDebug, $strStockId);

        $this->DeleteAllHoldings();
        $this->fCash = 0.0;
    }

    function AddCash($fVal)
    {
    	$this->fCash += $fVal;
    }
    
    function SubCash($fVal)
    {
    	$this->fCash -= $fVal;
    }
    
    function GetCash()
    {
    	return $this->fCash;
    }
    
    function DebugCash()
    {
		DebugVal(round($this->GetSum() - $this->fCash, 3), 'DebugCash');
	}
	
    function AddHolding($strHolding, $strName, $fVal)
    {
		if (is_numeric($strHolding))	$strHolding = BuildHongkongStockSymbol($strHolding);
   		DebugString($strHolding.' '.$strName);
   		$this->AddSum($fVal);
   		$this->InsertHolding($strHolding, $strName, strval(100.0 * $fVal / $this->fCash));
    }
}

?>
