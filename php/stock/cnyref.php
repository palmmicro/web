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
    	if ($history = $sql->GetNow())
    	{
    		$this->strPrice = $history['close'];
    		$this->strDate = $history['date'];
    		$this->strTime = '09:15:00';
    		$this->strPrevPrice = $sql->GetCloseStringPrev($this->strDate);
    	}
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
        if (self::$strDataSource == STOCK_EASTMONEY_DATA)
        {
        	$this->LoadEastMoneyCnyData($strSymbol);
        }
        else
        {
            $this->_loadDatabaseData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
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
