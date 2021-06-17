<?php

// ****************************** CnyReference class *******************************************************
class CnyReference extends MysqlReference
{
//    public static $strDataSource = STOCK_EASTMONEY_DATA;
    public static $strDataSource = STOCK_MYSQL_DATA;
    
    function CnyReference($strSymbol)
    {
        parent::MysqlReference($strSymbol);
        
        if (self::$strDataSource != STOCK_MYSQL_DATA)
        {
        	if ($this->strSqlId)
        	{
        		$this->_updateHistory();
        	}
        }
    }

    public function LoadData()
    {
        if (self::$strDataSource == STOCK_EASTMONEY_DATA)
        {
        	$this->LoadEastMoneyCnyData();
        }
        else
        {
            $this->_loadDatabaseData();
        }
    }
    
    function _loadDatabaseData()
    {
    	$strSymbol = $this->GetSymbol();
    	
    	$this->strSqlId = SqlGetStockId($strSymbol);
       	$this->LoadSqlData();
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
    
		$nav_sql = GetNavHistorySql();
		$nav_sql->InsertDaily($this->strSqlId, $this->GetDate(), $this->GetPrice());
	}

	function GetClose($strDate)
	{
		if ($strDate == $this->GetDate())	return $this->GetPrice();
		return SqlGetNavByDate($this->strSqlId, $strDate);
	}
}

?>
