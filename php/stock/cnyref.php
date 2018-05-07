<?php

// ****************************** CnyReference class *******************************************************
class CnyReference extends MysqlReference
{
//    public static $strDataSource = STOCK_EASTMONEY_FOREX;
    public static $strDataSource = STOCK_DB_FOREX;
    
    function _loadDatabaseData($strSymbol)
    {
    	$this->strSqlId = SqlGetStockId($strSymbol);
		$sql = new SqlForexHistory($this->strSqlId);
    	if ($history = $sql->GetNow())
    	{
    		$this->strPrice = $history['close'];
    		$this->strDate = $history['date'];
    		$this->strTime = '09:15:00';
    		$this->strPrevPrice = $sql->GetPrevCloseString($this->strDate);
    	}
        $this->strFileName = DebugGetChinaMoneyFile();
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
    }
    
	function _updateHistory()
	{
		if (FloatNotZero(floatval($this->strOpen)) == false)
		{
			$this->EmptyFile();
			return;
		}
    
		$sql = new SqlForexHistory($this->strSqlId);
		if ($sql->Get($this->strDate) == false)
		{
			$sql->Insert($this->strDate, $this->strPrice);
		}    
	}

    // constructor 
    function CnyReference($strSymbol)
    {
        if (self::$strDataSource == STOCK_EASTMONEY_FOREX)
        {
        	$this->LoadEastMoneyCnyData($strSymbol);
        }
        else
        {
            $this->_loadDatabaseData($strSymbol);
        }
        parent::MysqlReference($strSymbol);
        if (self::$strDataSource != STOCK_DB_FOREX)
        {
        	if ($this->strSqlId)
        	{
        		$this->_updateHistory();
        	}
        }
    }       
}

?>
