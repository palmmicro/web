<?php

// ****************************** StockTransaction Class *******************************************************

class StockTransaction 
{
    var $iTotalShares;          // Total number of stock shares
    var $fTotalCost;            // Total cost of stock shares
    var $iTotalRecords;

    // constructor 
    function StockTransaction() 
    {
        $this->Zero();
    }

    function Zero()
    {
        $this->fTotalCost = 0.0;
        $this->iTotalShares = 0;
        $this->iTotalRecords = 0;
    }
    
    function SetValue($iTotalRecords, $iTotalShares, $fTotalCost)
    {
        $this->fTotalCost = $fTotalCost;
        $this->iTotalShares = $iTotalShares;
        $this->iTotalRecords = $iTotalRecords;
    }
    
    function AddTransaction($iShares, $fCost)
    {
        $this->fTotalCost += $fCost;
        $this->iTotalShares += $iShares;
        $this->iTotalRecords ++;
    }
    
    function GetAvgCost()
    {
        if ($this->iTotalShares != 0)
        {
            return $this->fTotalCost / $this->iTotalShares;
        }
        return 0.0;
    }
}

?>
