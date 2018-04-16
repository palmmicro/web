<?php

// ****************************** MysqlReference class *******************************************************
class MysqlReference extends StockReference
{
    var $strSqlId = false;      // ID in mysql database
    var $strSqlName = false;
    
    function GetStockId()
    {
        return $this->strSqlId;
    }
    
    function _loadSqlId()
    {
    	if ($this->strSqlId)	return;	// Already set, like in CnyReference
    	
    	$this->strSqlId = SqlGetStockId($this->strSqlName);
        if ($this->strSqlId == false)
        {
            if ($this->bHasData)
            {
                SqlInsertStock($this->strSqlName, $this->GetEnglishName(), $this->GetChineseName());
                $this->strSqlId = SqlGetStockId($this->strSqlName);
            }
        }
    }
    
    // constructor 
    function MysqlReference($strSymbol) 
    {
        parent::StockReference($strSymbol);
        if ($this->strSqlName == false)
        {
        	$this->strSqlName = $strSymbol;
        }
        $this->_loadSqlId();
        if ($this->strSqlId)
        {
            $this->strDescription = SqlGetStockDescription($this->strSqlName);
        }
    }
}

?>
