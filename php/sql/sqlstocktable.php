<?php
require_once('sqltable.php');

// ****************************** SqlStockTable class *******************************************************
class SqlStockTable extends SqlTable
{
	var $strStockId;
	
    function BuildWhere_date_stock($strDate)
    {
    	return _SqlBuildWhere_date_stock($strDate, $this->strStockId);
    }
    
    function BuildWhere_stock()
    {
    	return _SqlBuildWhere_stock($this->strStockId);
    }
    
    function GetStockId()
    {
    	return $this->strStockId;
    }
    
    // constructor 
    function SqlStockTable($strStockId, $strTableName) 
    {
    	$this->strStockId = $strStockId;
        parent::SqlTable($strTableName);
    }
    
    function Count()
    {
    	return SqlTable::Count($this->BuildWhere_stock());
    }
    
    function DeleteAll()
    {
    	return $this->Delete($this->BuildWhere_stock());
    }
}

?>
