<?php
require_once('sqltable.php');

// ****************************** StockSql class *******************************************************
class StockSql extends KeyNameSql
{
    function StockSql()
    {
        parent::KeyNameSql('stock', 'symbol');
    }

    function Create()
    {
    	$str = ' `symbol` VARCHAR( 32 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	. ' `name` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' UNIQUE ( `symbol` )';
    	return $this->CreateIdTable($str);
    }
    
    function _getFieldArray($strSymbol, $strName)
    {
    	$strName = UrlCleanString($strName);
    	return array('symbol' => $strSymbol,
    				   'name' => $strName);
    }
    
    function Insert($strSymbol, $strName)
    {
    	return $this->InsertData($this->_getFieldArray($strSymbol, $strName));
    }

	function Update($strId, $strSymbol, $strName)
    {
		return $this->UpdateById($this->_getFieldArray($strSymbol, $strName), $strId);
	}
	
    function Write($strSymbol, $strName)
    {
    	if ($record = $this->Get($strSymbol))
    	{
    		if ((strpos($record['name'], '-') === false) && ($strName != $record['name']))
    		{
    			return $this->Update($record['id'], $strSymbol, $strName);
    		}
    	}
    	else
    	{
    		return $this->Insert($strSymbol, $strName);
    	}
    	return false;
    }
}

// ****************************** Stock table *******************************************************
function SqlGetStock($strSymbol)
{
	$sql = new StockSql();
	return $sql->Get($strSymbol);
}

function SqlGetStockId($strSymbol)
{
	$sql = new StockSql();
	if ($strStockId = $sql->GetId($strSymbol))
	{
		return $strStockId;
	}
   	DebugString($strSymbol.' not in stock table');
	return false;
}

function SqlGetStockSymbol($strStockId)
{
	$sql = new StockSql();
	return $sql->GetKeyName($strStockId);
}

?>
