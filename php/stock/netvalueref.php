<?php

class NetValueReference extends MysqlReference
{
	var $sql;
	var $fund_est_sql;
	
    function NetValueReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);
        
       	$this->fund_est_sql = new FundEstSql();
        if ($this->IsFundA())
        {
       		StockCompareEstResult($this->fund_est_sql, $this->GetStockId(), $this->GetPrice(), $this->GetDate(), $this->GetSymbol());
        }
    }
    
    public function LoadData()
    {
    	$strSymbol = $this->GetSymbol();
    	$this->strSqlId = SqlGetStockId($strSymbol);
        if ($this->IsFundA())
        {
        	$this->LoadSinaFundData();
        }
        else
        {
        	$this->LoadSqlData();
        }
    }

    function GetFundEstSql()
    {
    	return $this->fund_est_sql;
    }
}

?>
