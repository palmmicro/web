<?php
require_once('sqltable.php');
require_once('sqlstocksymbol.php');

// ****************************** SqlStockTable class *******************************************************
class SqlStockTable extends SqlTable
{
	var $strStockId;
	
    function _buildWhere_date_stock($strDate)
    {
    	return _SqlBuildWhere_date_stock($strDate, $this->strStockId);
    }
    
    // constructor 
    function SqlStockTable($strSymbol, $strTableName) 
    {
    	$this->strStockId = SqlGetStockId($strSymbol);
        parent::SqlTable($strTableName);
    }
}

?>
