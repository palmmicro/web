<?php

// ****************************** MultiCurrency Class *******************************************************

class MultiCurrency
{
    var $fCNY;
    var $fHKD;
    var $fUSD;

    var $fConvertCNY;
    var $fConvertHKD;
    var $fConvertUSD;
    
    // constructor 
    function MultiCurrency() 
    {
        $this->fCNY = 0.0;
        $this->fHKD = 0.0;
        $this->fUSD = 0.0;
    }

    function Convert($fUSDCNY, $fHKDCNY) 
    {
        $this->fConvertCNY = $this->fCNY;
        if ($fUSDCNY)   $this->fConvertCNY += $this->fUSD * $fUSDCNY;    
        if ($fHKDCNY)   $this->fConvertCNY += $this->fHKD * $fHKDCNY;

        if ($fUSDCNY)   $this->fConvertUSD = $this->fConvertCNY / $fUSDCNY;
        else              $this->fConvertUSD = 0.0;  
        
        if ($fHKDCNY)   $this->fConvertHKD = $this->fConvertCNY / $fHKDCNY;
        else              $this->fConvertHKD = 0.0;  
    }
}

// ****************************** StockGroup Class *******************************************************

class StockGroup 
{
    var $multi_amount;
    var $multi_profit;
    
    // constructor 
    function StockGroup() 
    {
        $this->multi_amount = new MultiCurrency();
        $this->multi_profit = new MultiCurrency();
    }

    function OnStockTransaction($trans)
    {
        $sym = $trans->ref->sym;
        if ($sym->IsSymbolA())
        {
            $this->multi_amount->fCNY += $trans->GetValue();
            $this->multi_profit->fCNY += $trans->GetProfit();
        }
        else if ($sym->IsSymbolH())
        {
            $this->multi_amount->fHKD += $trans->GetValue();
            $this->multi_profit->fHKD += $trans->GetProfit();
        }
        else 
        {
            $this->multi_amount->fUSD += $trans->GetValue();
            $this->multi_profit->fUSD += $trans->GetProfit();
        }
    }
    
    function ConvertCurrency($fUSDCNY, $fHKDCNY) 
    {
        $this->multi_amount->Convert($fUSDCNY, $fHKDCNY);
        $this->multi_profit->Convert($fUSDCNY, $fHKDCNY);
    }
}

?>
