<?php
require_once('../../php/gb2312.php');
require_once('_holdingscsvfile.php');

class _EtfHoldingsFile extends _HoldingsCsvFile
{
    var $fCash;
	
    public function __construct($strFileName, $strStockId) 
    {
        parent::__construct($strFileName, $strStockId);

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
    
    function Done()
    {
		if ($this->UpdateHoldingsDate())
		{
			DebugVal(round($this->GetSum() - $this->fCash, 3), 'Done');
			return true;
		}
		return false;
	}
	
    function AddHolding($strHolding, $strName, $fVal)
    {
   		DebugString($strHolding.' '.$strName.' '.strval($fVal));
   		$this->AddSum($fVal);
   		$this->InsertHolding($strHolding, $strName, strval(100.0 * $fVal / $this->fCash));
    }
}

?>
