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
}

// ****************************** Stock table *******************************************************
function SqlInsertStock($strSymbol, $strName)
{
	DebugString('SqlInsertStock '.$strSymbol);
	$sql = new StockSql();
	return $sql->Insert($strSymbol, $strName);
}

function SqlUpdateStock($strId, $strSymbol, $strName)
{
	$sql = new StockSql();
	return $sql->Update($strId, $strSymbol, $strName);
}

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

// ****************************** Other SQL and stock related functions *******************************************************

function SqlUpdateStockChineseDescription($strSymbol, $strChinese)
{
    $bTemp = false;
    $strChinese = trim($strChinese);
    $str = substr($strChinese, 0, 2); 
    if ($str == 'XD' || $str == 'XR' || $str == 'DR') 
    {
        DebugString($strChinese);
        $strChinese = substr($strChinese, 2);
        $bTemp = true;
    }
    
    if ($record = SqlGetStock($strSymbol))
    {
        if ($bTemp == false)
        {
            if (strlen($strChinese) > strlen($record['name']))
            {
                SqlUpdateStock($record['id'], $strSymbol, $strChinese);
                DebugString('UpdateStock:'.$strSymbol.' '.$strChinese);
            }
        }
    }
    else
    {
        SqlInsertStock($strSymbol, $strChinese);
        DebugString('InsertStock:'.$strSymbol.' '.$strChinese);
    }
    return $bTemp;
}

?>
