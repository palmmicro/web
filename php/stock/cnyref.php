<?php

// ****************************** CnyReference class *******************************************************
class CnyReference extends MysqlReference
{
//    public static $strDataSource = STOCK_EASTMONEY_DATA;
    public static $strDataSource = STOCK_MYSQL_DATA;
    
    var $sql = false;
    
    function CnyReference($strSymbol)
    {
        $sym = new StockSymbol($strSymbol);
        if (self::$strDataSource == STOCK_EASTMONEY_DATA)
        {
        	$this->LoadEastMoneyCnyData($sym);
        }
        else
        {
            $this->_loadDatabaseData($strSymbol);
        }
        parent::MysqlReference($sym);
        if (self::$strDataSource != STOCK_MYSQL_DATA)
        {
        	if ($this->strSqlId)
        	{
        		$this->_updateHistory();
        	}
        }
    }
    
    function _loadDatabaseData($strSymbol)
    {
    	$this->strSqlId = SqlGetStockId($strSymbol);
		$this->sql = new NetValueHistorySql($this->strSqlId);
       	$this->LoadSqlData($this->sql);
   		$this->strTime = '09:15:00';
        $this->strFileName = DebugGetChinaMoneyFile();
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
    }
    
	function _updateHistory()
	{
		if (empty($this->strOpen))
		{
			$this->EmptyFile();
			return;
		}
    
		$this->sql = new NetValueHistorySql($this->strSqlId);
		$this->sql->Insert($this->strDate, $this->strPrice);
	}

	function GetClose($strDate)
	{
		if ($this->sql)
		{
			return $this->sql->GetClose($strDate);
		}
		return false;
	}
}

?>
