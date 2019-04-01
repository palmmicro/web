<?php
require_once('stocktrans.php');
require_once('class/multi_currency.php');

// ****************************** StockGroup Class *******************************************************

class StockGroup 
{
    var $strGroupId = false;
    
    var $multi_amount;
    var $multi_profit;
    
    function StockGroup() 
    {
        $this->multi_amount = new MultiCurrency();
        $this->multi_profit = new MultiCurrency();
    }

    function GetGroupId()
    {
    	return $this->strGroupId;
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

class MyStockGroup extends StockGroup
{
    var $arStockTransaction = array();
    
    var $arbi_trans;
    var $bCountArbitrage;
    
    function GetStockTransactionByStockGroupItemId($strStockGroupItemId)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->strStockGroupItemId == $strStockGroupItemId)     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionByStockId($strStockId)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->GetStockId() == $strStockId)     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionBySymbol($strSymbol)
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)   return $trans;
        }
        return false;
    }
    
    function GetStockTransactionCN()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolA())     return $trans;
        }
        return false;
    }

    function GetStockTransactionHK()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolH())     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionUS()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->sym->IsSymbolUS())     return $trans;
        }
        return false;
    }
    
    function _addTransaction($ref)
    {
        $this->arStockTransaction[] = new MyStockTransaction($ref, $this->strGroupId);
    }
    
    function _checkSymbol($strSymbol)
    {
        if ($this->GetStockTransactionBySymbol($strSymbol))  return;
        
        $this->_addTransaction(new MyStockReference($strSymbol));
    }
        
    function AddTransaction($strSymbol, $iShares, $fCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)
            {
                $trans->AddTransaction($iShares, $fCost);
                break;
            }
        }
    }

    function SetValue($strSymbol, $iTotalRecords, $iTotalShares, $fTotalCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetStockSymbol() == $strSymbol)
            {
                $trans->SetValue($iTotalRecords, $iTotalShares, $fTotalCost);
                $this->OnStockTransaction($trans);
                break;
            }
        }
    }

    function GetTotalRecords()
    {
        $iTotal = 0;
        foreach ($this->arStockTransaction as $trans)
        {
            $iTotal += $trans->iTotalRecords;
        }
        return $iTotal;
    }
    
    function _checkArbitrage($strSymbol)
    {
        if ($this->arbi_trans)
        {
            if ($this->arbi_trans->GetStockSymbol() != $strSymbol)
            {
                $this->bCountArbitrage = false;
            }
        }
        else
        {
            $trans = $this->GetStockTransactionBySymbol($strSymbol);
            if ($trans)
            {
                $this->arbi_trans = new MyStockTransaction($trans->ref, $this->strGroupId);
                $this->bCountArbitrage = true;
            }
        }
    }
    
    function _onArbitrageTransaction($strSymbol, $transaction)
    {
        $this->_checkArbitrage($strSymbol);
        if ($this->bCountArbitrage)
        {
            AddSqlTransaction($this->arbi_trans, $transaction);
            return true;
        }
        return false;
    }
    
    function OnArbitrage()
    {
		$sql = new StockGroupItemSql($this->strGroupId);
        if ($result = $sql->GetAllStockTransaction()) 
        {   
            $arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($sql);
            while ($transaction = mysql_fetch_assoc($result)) 
            {
                $strSymbol = $arGroupItemSymbol[$transaction['groupitem_id']];
                if ($this->_onArbitrageTransaction($strSymbol, $transaction) == false)  break;
            }
            @mysql_free_result($result);
        }
    }
    
    // constructor 
    function MyStockGroup($strGroupId, $arRef) 
    {
        $this->strGroupId = $strGroupId;
        $this->arbi_trans = false;
        
        foreach ($arRef as $ref)
        {
            $this->_addTransaction($ref);
        }
        parent::StockGroup();
        
        $sql = new StockGroupItemSql($strGroupId);
        if ($result = $sql->GetAll()) 
        {   
            while ($groupitem = mysql_fetch_assoc($result)) 
            {
                if (intval($groupitem['record']) > 0)
                {
                    $this->SetValue(SqlGetStockSymbol($groupitem['stock_id']), intval($groupitem['record']), intval($groupitem['quantity']), floatval($groupitem['cost']));
                }
            }
            @mysql_free_result($result);
        }
    }
}


?>
