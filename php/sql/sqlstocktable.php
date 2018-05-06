<?php
require_once('sqltable.php');

// ****************************** SqlStockTable class *******************************************************
class SqlStockTable extends SqlTable
{
	var $strStockId;
	
    function _buildWhere_date_stock($strDate)
    {
    	return _SqlBuildWhere_date_stock($strDate, $this->strStockId);
    }
    
    function _buildWhere_stock()
    {
    	return _SqlBuildWhere_stock($this->strStockId);
    }
    
    // constructor 
    function SqlStockTable($strStockId, $strTableName) 
    {
    	$this->strStockId = $strStockId;
        parent::SqlTable($strTableName);
    }
}

?>
