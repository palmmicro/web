<?php
require_once('sqltable.php');

// ****************************** StockSql class *******************************************************
class StockSql extends TableSql
{
    function StockSql()
    {
        parent::TableSql(TABLE_STOCK);
        $this->Create();
    }

    function Create()
    {
    	$str = ' `symbol` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' `name` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' UNIQUE ( `symbol` )';
    	return $this->CreateTable($str);
    }
    
    function _getFieldArray($strSymbol, $strName)
    {
    	return array('symbol' => $strSymbol,
    				   'name' => $strName);
    }
    
    function Insert($strSymbol, $strName)
    {
    	$strName = UrlCleanString($strName);
    	return $this->InsertData($this->_getFieldArray($strSymbol, $strName));
    }

	function Update($strId, $strSymbol, $strName)
    {
    	$strName = UrlCleanString($strName);
		return $this->UpdateById("symbol = '$strSymbol', name = '$strName'", $strId);
	}
	
    function Get($strSymbol)
    {
    	return $this->GetSingleData(_SqlBuildWhere('symbol', $strSymbol));
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`symbol` ASC', _SqlBuildLimit($iStart, $iNum));
    }

    function GetSymbol($strStockId)
    {
    	if ($record = $this->GetById($strStockId))
    	{
    		return $record['symbol'];
    	}
    	return false;
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
	return $sql->GetSymbol($strStockId);
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
