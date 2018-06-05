<?php
require_once('sqltable.php');

// ****************************** StockTableSql class *******************************************************
class StockTableSql extends TableSql
{
	var $strStockId;
	
    function BuildWhere_stock_date($strDate)
    {
		return _SqlBuildWhereAndArray(array('stock_id' => $this->strStockId, 'date' => $strDate));
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
    function StockTableSql($strStockId, $strTableName) 
    {
    	$this->strStockId = $strStockId;
        parent::TableSql($strTableName);
    }
    
    function Count()
    {
    	return TableSql::Count($this->BuildWhere_stock());
    }
    
    function DeleteAll()
    {
    	return $this->Delete($this->BuildWhere_stock());
    }
}

?>
