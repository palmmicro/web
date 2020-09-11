<?php
require_once('sqlkeyname.php');
require_once('sqlkeytable.php');

class StockSql extends KeyNameSql
{
    function StockSql()
    {
        parent::KeyNameSql(TABLE_STOCK, 'symbol');
    }

    public function Create()
    {
    	$str = ' `symbol` VARCHAR( 32 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	. ' `name` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' UNIQUE ( `symbol` )';
    	return $this->CreateIdTable($str);
    }

    function WriteSymbol($strSymbol, $strName, $bCheck = true)
    {
    	$strName = SqlCleanString($strName);
    	$ar = array('symbol' => $strSymbol,
    				  'name' => $strName);
    	
    	if ($record = $this->GetRecord($strSymbol))
    	{	
    		unset($ar['symbol']);
    		$strOrig = $record['name'];
    		if ($strName != $strOrig)
    		{
    			if (($bCheck == false) || (strpos($strOrig, '-') === false))
    			{	// 股票说明中带'-'的是手工修改的, 防止在自动更新中被覆盖.
    				return $this->UpdateById($ar, $record['id']);
    			}
    		}
    	}
    	else
    	{
    		return $this->InsertArray($ar);
    	}
    	return false;
    }
    
    function InsertSymbol($strSymbol, $strName)
    {
    	if ($this->GetRecord($strSymbol) == false)
    	{
    		return $this->WriteSymbol($strSymbol, $strName);
    	}
    	return false;
    }
    
    function GetStockName($strSymbol)
    {
    	if ($record = $this->GetRecord($strSymbol))
    	{	
    		return $record['name'];
    	}
    	return false;
    }
}

// ****************************** Stock symbol functionse *******************************************************
function GetStockSql()
{
	global $acct;
	
	return $acct->GetStockSql();
}

function SqlGetStockName($strSymbol)
{
	$sql = GetStockSql();
	return $sql->GetStockName($strSymbol);
}

function SqlGetStockId($strSymbol)
{
	$sql = GetStockSql();
	if ($strStockId = $sql->GetId($strSymbol))
	{
		return $strStockId;
	}
   	DebugString($strSymbol.' not in stock table');
	return false;
}

function SqlGetStockSymbol($strStockId)
{
	$sql = GetStockSql();
	return $sql->GetKey($strStockId);
}

// ****************************** StockTableSql class *******************************************************
class StockTableSql extends KeyTableSql
{
    function StockTableSql($strTableName, $strStockId) 
    {
        parent::KeyTableSql($strTableName, $strStockId, TABLE_STOCK);
    }
}

?>
