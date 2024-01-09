<?php

class NetValueReference extends MysqlReference
{
	var $fund_est_sql;
	
    public function __construct($strSymbol) 
    {
        parent::__construct($strSymbol);
        
       	$this->fund_est_sql = new FundEstSql();
        if ($this->IsFundA())
        {
       		if (StockCompareEstResult($this->fund_est_sql, $this->GetStockId(), $this->GetPrice(), $this->GetDate(), $this->GetSymbol()))
       		{	// new NAV
       		}
        }
    }
    
    public function LoadData()
    {
    	$strSymbol = $this->GetSymbol();
    	$this->strSqlId = SqlGetStockId($strSymbol);
        if ($this->IsFundA())
        {
        	$this->LoadSinaFundData();
        	$this->bConvertGB2312 = true;     // Sina name is GB2312 coded
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
