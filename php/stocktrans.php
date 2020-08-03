<?php

// ****************************** StockTransaction class  *******************************************************
class StockTransaction 
{
    var $iTotalShares;          // Total number of stock shares
    var $fTotalCost;            // Total cost of stock shares
    var $iTotalRecords;

    function StockTransaction() 
    {
        $this->SetValue();
    }

    function GetTotalShares()
    {
        return $this->iTotalShares;
    }
    
    function GetTotalCost()
    {
        return $this->fTotalCost;
    }
    
    function GetTotalRecords()
    {
        return $this->iTotalRecords;
    }
    
    function SetValue($iTotalRecords = 0, $iTotalShares = 0, $fTotalCost = 0.0)
    {
        $this->fTotalCost = $fTotalCost;
        $this->iTotalShares = $iTotalShares;
        $this->iTotalRecords = $iTotalRecords;
    }
    
    function AddTransaction($iShares, $fCost = 0.0)
    {
        $this->fTotalCost += $fCost;
        $this->iTotalShares += $iShares;
        $this->iTotalRecords ++;
    }
    
    function Add($trans)
    {
    	$this->AddTransaction($trans->GetTotalShares(), $trans->GetTotalCost()); 
    }
    
    function GetAvgCost()
    {
		return ($this->iTotalShares != 0) ? strval($this->fTotalCost / $this->iTotalShares) : '';
    }
}

class MyStockTransaction extends StockTransaction
{
    var $ref;                       // MyStockReference
    
    var $strGroupId;
    var $strStockGroupItemId;
    
    function MyStockTransaction($ref, $strGroupId) 
    {
        $this->ref = $ref;
        $this->strGroupId = $strGroupId;
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

    function GetRef()
    {
    	return $this->ref;
    }
    
    function GetGroupId()
    {
    	return $this->strGroupId;
    }
    
    function GetSymbol()
    {
        if ($this->ref)
        {
            return $this->ref->GetSymbol();
        }
        return false;
    }
    
    function GetAvgCostDisplay()
    {
        if ($this->ref)
        {
        	return $this->ref->GetPriceDisplay($this->GetAvgCost());
        }
        return '';
    }
    
    function GetValue()
    {
        if ($this->ref)     return $this->GetTotalShares() * floatval($this->ref->GetPrice());
        return 0.0;
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
    if ($result = $sql->trans_sql->GetRecord($strGroupItemId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            AddSqlTransaction($trans, $record);
        }
        @mysql_free_result($result);
    }
    $sql->Update($strGroupItemId, strval($trans->GetTotalShares()), strval($trans->fTotalCost), strval($trans->iTotalRecords));
}



?>
