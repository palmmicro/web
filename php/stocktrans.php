<?php

// ****************************** StockTransaction class  *******************************************************
class StockTransaction 
{
    var $iTotalShares;          // Total number of stock shares
    var $fTotalCost;            // Total cost of stock shares
    var $iTotalRecords;

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

class MyStockTransaction extends StockTransaction
{
    var $ref;                       // MyStockReference
    var $strStockGroupItemId;
    
    function MyStockTransaction($ref, $strGroupId) 
    {
        $this->ref = $ref;
        if ($strGroupId)
        {
            if ($ref)
            {
            	$sql = new StockGroupItemSql($strGroupId);
            	$this->strStockGroupItemId = $sql->GetId($ref->GetStockId());
            }
        }
        parent::StockTransaction();
    }

    function GetStockSymbol()
    {
        if ($this->ref)
        {
            return $this->ref->GetStockSymbol();
        }
        return false;
    }
    
    function GetAvgCostDisplay()
    {
        if ($this->ref)
        {
        	return $this->ref->GetPriceDisplay(strval($this->GetAvgCost()), false);
        }
        return '';
    }
    
    function GetValue()
    {
        if ($this->ref)     return $this->iTotalShares * $this->ref->fPrice;
        return 0.0;
    }

    function GetValueDisplay()
    {
        return GetNumberDisplay($this->GetValue());
    }
    
    function GetProfit()
    {
        return $this->GetValue() - $this->fTotalCost;
    }
    
    function GetProfitDisplay()
    {
        return GetNumberDisplay($this->GetProfit());
    }
}

// ****************************** Stock Transaction functions *******************************************************
function GetSqlTransactionDate($record)
{
    return strstr($record['filled'], ' ', true);
}

function AddSqlTransaction($trans_class, $record)
{
    $iQuantity = intval($record['quantity']);
    $trans_class->AddTransaction($iQuantity, $iQuantity * floatval($record['price']) + floatval($record['fees']));
}

function UpdateStockGroupItemTransaction($sql, $strGroupItemId)
{
    $trans = new StockTransaction();
    if ($result = $sql->trans_sql->Get($strGroupItemId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            AddSqlTransaction($trans, $record);
        }
        @mysql_free_result($result);
    }
    $sql->Update($strGroupItemId, strval($trans->iTotalShares), strval($trans->fTotalCost), strval($trans->iTotalRecords));
}



?>
