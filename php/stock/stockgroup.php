<?php
require_once('/php/class/multi_currency.php');

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
