<?php

class EtfHoldingsReference extends MyStockReference
{
    var $uscny_ref;
    var $hkcny_ref;
    
    var $ar_holdings_ref = array();

    function EtfHoldingsReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);

        $this->hkcny_ref = new CnyReference('HKCNY');
   		$this->uscny_ref = new CnyReference('USCNY');
   		
   		$ar = SqlGetHoldingsSymbolArray($strSymbol);
    	foreach ($ar as $strHoldingSymbol)
    	{
    		$this->ar_holdings_ref[] = new MyStockReference($strHoldingSymbol);
    	}
    }
    
    function GetHoldingRefArray()
    {
    	return $this->ar_holdings_ref;
    }
/*    
    function GetHoldingsIdArray() 
    {
        $holdings_sql = GetEtfHoldingsSql();
    	$arId = array();
    	$ar = $holdings_sql->GetHoldingsArray($this->GetStockId());
    	foreach ($ar as $strId => $strRatio)
    	{
    		$arId[] = $strId;
    	}
    	return $arId;
    }
*/    
}

?>
