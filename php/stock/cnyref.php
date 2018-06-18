<?php

// ****************************** CnyReference class *******************************************************
class CnyReference extends MysqlReference
{
//    public static $strDataSource = STOCK_EASTMONEY_DATA;
    public static $strDataSource = STOCK_MYSQL_DATA;
    
    function _loadDatabaseData($strSymbol)
    {
    	$this->strSqlId = SqlGetStockId($strSymbol);
		$sql = new ForexHistorySql($this->strSqlId);
       	$this->LoadSqlData($sql);
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
    
		$sql = new ForexHistorySql($this->strSqlId);
		if ($sql->Get($this->strDate) == false)
		{
			$sql->Insert($this->strDate, $this->strPrice);
		}    
	}

    // constructor 
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
}

?>
