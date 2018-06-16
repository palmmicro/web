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
    
    function GetEnglishName()
    {
    	if ($this->bConvertGB2312)
    	{
    		return FromGB2312ToUTF8($this->strName);
    	}
   		return $this->strName;
    }
    
    function GetChineseName()
    {
    	if ($this->strChineseName)
    	{
    		if ($this->bConvertGB2312)
    		{
    			return FromGB2312ToUTF8($this->strChineseName);
    		}
    		return $this->strChineseName;
    	}
    	return $this->GetEnglishName();	// 数据中只有唯一一个中文或者英文名字的情况下, 优先放strName字段.
    }
    
    function _loadSqlId()
    {
    	if ($this->strSqlId)	return;	// Already set, like in CnyReference
    	
    	$sql = new StockSql();
    	$this->strSqlId = $sql->GetId($this->strSqlName);
//    	DebugString($this->strSqlName);
        if ($this->strSqlId == false)
        {
            if ($this->bHasData)
            {
                $sql->Insert($this->strSqlName, $this->GetEnglishName(), $this->GetChineseName());
                $this->strSqlId = $sql->GetId($this->strSqlName);
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
    }
}

?>
