<?php
require_once('stocktrans.php');
require_once('class/multi_currency.php');

// ****************************** StockGroup Class *******************************************************

class StockGroup
{
    var $multi_amount;
    var $multi_profit;
    
    var $strGroupId = false;
    
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
        $sym = $trans->ref;
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
    
    function ConvertCurrency($strUSDCNY, $strHKDCNY) 
    {
        $this->multi_amount->Convert($strUSDCNY, $strHKDCNY);
        $this->multi_profit->Convert($strUSDCNY, $strHKDCNY);
    }
}

class MyStockGroup extends StockGroup
{
    var $arStockTransaction = array();
    
    var $arbi_trans;
    var $bCountArbitrage;
    
    function GetStockTransactionArray()
    {
    	return $this->arStockTransaction;
    }
    
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
            if ($trans->GetSymbol() == $strSymbol)   return $trans;
        }
        return false;
    }
    
    function GetStockTransactionCN()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->IsSymbolA())     return $trans;
        }
        return false;
    }

    function GetStockTransactionNoneCN()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->IsSymbolA() == false)     return $trans;
        }
        return false;
    }

    function GetStockTransactionHK()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->IsSymbolH())     return $trans;
        }
        return false;
    }
    
    function GetStockTransactionUS()
    {
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->ref->IsSymbolUS())     return $trans;
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
		$this->_addTransaction(StockGetReference($strSymbol));
    }
/*        
    function AddTransaction($strSymbol, $iShares, $fCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetSymbol() == $strSymbol)
            {
                $trans->AddTransaction($iShares, $fCost);
                break;
            }
        }
    }*/

    function SetValue($strSymbol, $iTotalRecords, $iTotalShares, $fTotalCost)
    {
        $this->_checkSymbol($strSymbol);
        foreach ($this->arStockTransaction as $trans)
        {
            if ($trans->GetSymbol() == $strSymbol)
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
            $iTotal += $trans->GetTotalRecords();
        }
        return $iTotal;
    }
    
    function _checkArbitrage($strSymbol)
    {
        if ($this->arbi_trans)
        {
            if ($this->arbi_trans->GetSymbol() != $strSymbol)
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
    
    function _onArbitrageTransaction($strSymbol, $record)
    {
        $this->_checkArbitrage($strSymbol);
        if ($this->bCountArbitrage)
        {
            AddSqlTransaction($this->arbi_trans, $record);
            return true;
        }
        return false;
    }
    
    function OnArbitrage()
    {
		$item_sql = new StockGroupItemSql($this->strGroupId);
        if ($arGroupItemSymbol = SqlGetStockGroupItemSymbolArray($item_sql))
        {
        	if ($result = $item_sql->GetAllStockTransaction()) 
        	{   
        		while ($record = mysql_fetch_assoc($result)) 
        		{
        			$strSymbol = $arGroupItemSymbol[$record['groupitem_id']];
        			if ($this->_onArbitrageTransaction($strSymbol, $record) == false)  break;
        		}
        		@mysql_free_result($result);
        	}
        }
    }
    
    function MyStockGroup($strGroupId, $arRef) 
    {
        parent::StockGroup();
        
        $this->strGroupId = $strGroupId;
        $this->arbi_trans = false;
        foreach ($arRef as $ref)
        {
            $this->_addTransaction($ref);
        }
        
        $sql = new StockGroupItemSql($strGroupId);
        if ($result = $sql->GetAll()) 
        {   
            while ($record = mysql_fetch_assoc($result)) 
            {
                if (intval($record['record']) > 0)
                {
                    $this->SetValue(SqlGetStockSymbol($record['stock_id']), intval($record['record']), intval($record['quantity']), floatval($record['cost']));
                }
            }
            @mysql_free_result($result);
        }
    }
}


?>
