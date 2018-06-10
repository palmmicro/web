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
    	
    	$sql = new StockSql();
    	$sql->Create();
    	$this->strSqlId = $sql->GetTableId($this->strSqlName);
    	DebugString($this->strSqlName);
        if ($this->strSqlId == false)
        {
            if ($this->bHasData)
            {
                $sql->Insert($this->strSqlName, $this->GetEnglishName(), $this->GetChineseName());
                $this->strSqlId = $sql->GetTableId($this->strSqlName);
            }
        }
    }
    
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
