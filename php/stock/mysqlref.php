<?php

// ****************************** MysqlReference class *******************************************************
class MysqlReference extends StockReference
{
    var $strSqlId = false;      // ID in mysql database
	var $bConvertGB2312 = false;

    var $fFactor = 1.0;			// 'close' field in calibrationhistory table
    
    var $iNavCount = 0;
    
    function MysqlReference($strSymbol) 
    {
        parent::StockReference($strSymbol);
        $this->LoadData();

    	if ($this->strSqlId)
    	{	// Already set, like in CnyReference
    	}
    	else
    	{
    		$this->_loadSqlId($this->GetSymbol());
    	}

    	if ($this->strSqlId)
    	{
    		$nav_sql = GetNavHistorySql();
    		$this->iNavCount = $nav_sql->Count($this->strSqlId);
    	}
    }
    
    public function LoadData()
    {
    	$this->bHasData = false;
    }
    
	public function GetClose($strDate)
	{
		if ($strDate == $this->GetDate())	return $this->GetPrice();
//		return SqlGetHisByDate($this->strSqlId, $strDate);
		$his_sql = GetStockHistorySql();
		return $his_sql->GetClose($this->strSqlId, $strDate);
	}

    function _loadSqlId($strSymbol)
    {
		$sql = GetStockSql();
        if ($this->HasData())
        {
            $sql->InsertSymbol($strSymbol, $this->GetChineseName());
        }
    	$this->strSqlId = $sql->GetId($strSymbol);
    }
    
    function GetStockId()
    {
        return $this->strSqlId;
    }
    
    function LoadSqlData()
    {
    	$nav_sql = GetNavHistorySql();
       	if ($record = $nav_sql->GetRecordNow($this->strSqlId))
       	{
   			$this->strPrice = $record['close'];
   			$this->strDate = $record['date'];
   			$this->strPrevPrice = $nav_sql->GetClosePrev($this->strSqlId, $this->strDate);
   		}
    }

    function CountNav()
    {
    	return $this->iNavCount;
    }
    
    function IsFund()
    {
    	if ($this->CountNav() > 0)	return true;
    	if ($this->IsFundA())			return true;
    	return false;
    }
    
    function GetEnglishName()
    {
    	if ($this->bConvertGB2312)
    	{
    		return GbToUtf8($this->strName);
    	}
   		return $this->strName;
    }
    
    function GetChineseName()
    {
    	if (empty($this->strChineseName))
    	{
    		return $this->GetEnglishName();	// 数据中只有唯一一个中文或者英文名字的情况下, 优先放strName字段.
    	}

    	if ($this->bConvertGB2312)
    	{
    		return GbToUtf8($this->strChineseName);
    	}
    	return $this->strChineseName;
    }
}

?>
