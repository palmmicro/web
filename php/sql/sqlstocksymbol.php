<?php
require_once('sqlkeyname.php');
require_once('sqlkeytable.php');
require_once('sqldailyclose.php');
require_once('sqlholdings.php');

class NavHistorySql extends DailyCloseSql
{
    function NavHistorySql() 
    {
        parent::DailyCloseSql(TABLE_NETVALUE_HISTORY);
    }
}

class StockEmaSql extends DailyCloseSql
{
    function StockEmaSql($iDays) 
    {
        parent::DailyCloseSql('stockema'.strval($iDays));
    }
}

class StockHistorySql extends DailyCloseSql
{
    function StockHistorySql() 
    {
        parent::DailyCloseSql(TABLE_STOCK_HISTORY);
    }

    public function Create()
    {
    	$str = ' `open` DOUBLE(10,3) NOT NULL ,'
         	  . ' `high` DOUBLE(10,3) NOT NULL ,'
         	  . ' `low` DOUBLE(10,3) NOT NULL ,'
         	  . ' `close` DOUBLE(10,3) NOT NULL ,'
         	  . ' `volume` BIGINT UNSIGNED NOT NULL ,'
         	  . ' `adjclose` DOUBLE(13,6) NOT NULL';
        return $this->CreateDailyCloseTable($str);
    }

    function WriteHistory($strStockId, $strDate, $strClose, $strOpen = '', $strHigh = '', $strLow = '', $strVolume = '', $strAdjClose = false)
    {
    	if ($strAdjClose == false)	$strAdjClose = $strClose;
    	
    	$ar = array('date' => $strDate,
    				   'open' => $strOpen,
    				   'high' => $strHigh,
    				   'low' => $strLow,
    				   'close' => $strClose,
    				   'volume' => $strVolume,
    				   'adjclose' => $strAdjClose);
    	
    	if ($record = $this->GetRecord($strStockId, $strDate))
    	{
    		unset($ar['date']);
    		if (abs(floatval($record['open']) - floatval($strOpen)) < 0.001)					unset($ar['open']);
    		if (abs(floatval($record['high']) - floatval($strHigh)) < 0.001)					unset($ar['high']);
    		if (abs(floatval($record['low']) - floatval($strLow)) < 0.001)						unset($ar['low']);
    		if (abs(floatval($record['close']) - floatval($strClose)) < 0.001)					unset($ar['close']);
    		if ($record['volume'] == $strVolume)													unset($ar['volume']);
    		if (abs(floatval($record['adjclose']) - floatval($strAdjClose)) < MIN_FLOAT_VAL)	unset($ar['adjclose']);
    		
    		if (count($ar) > 0)	return $this->UpdateById($ar, $record['id']);
    	}
    	else	return $this->InsertArrays($this->MakeFieldKeyId($strStockId), $ar);
    	return false;
    }
    
    function UpdateClose($strId, $strClose)
    {
		return $this->UpdateById(array('close' => $strClose, 'adjclose' => $strClose), $strId);
    }

    function UpdateAdjClose($strId, $strAdjClose)
    {
		return $this->UpdateById(array('adjclose' => $strAdjClose), $strId);
    }

    function DeleteByZeroVolume($strStockId)
    {
    	return $this->DeleteData("volume = '0' AND ".$this->BuildWhere_key($strStockId));
    }

    function GetVolume($strStockId, $strDate)
    {
    	if ($record = $this->GetRecord($strStockId, $strDate))
    	{
    		return $record['volume'];
    	}
    	return '0';
    }

    function _getAdjCloseString($callback, $strStockId, $strDate = false)
    {
    	if ($record = $this->$callback($strStockId, $strDate))
    	{
    		return rtrim0($record['adjclose']);
    	}
    	return false;
    }
    
    function GetAdjClose($strStockId, $strDate)
    {
    	$str = $this->_getAdjCloseString('GetRecord', $strStockId, $strDate);
		if ($str === false)		$str = $this->_getAdjCloseString('GetRecordPrev', $strStockId, $strDate);	// when hongkong market on holiday
		return $str;
    }
}

class StockSql extends KeyNameSql
{
    var $his_sql;
    var $nav_sql;
	var $holdings_sql;
    
    var $ema50_sql;
    var $ema200_sql;
    
    function StockSql()
    {
        parent::KeyNameSql(TABLE_STOCK, 'symbol');
        
       	$this->his_sql = new StockHistorySql();
       	$this->nav_sql = new NavHistorySql();
        $this->holdings_sql = new HoldingsSql();
       	
       	$this->ema50_sql = new StockEmaSql(50);
       	$this->ema200_sql = new StockEmaSql(200);
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
  			DebugString('新增:'.$strSymbol.'-'.$strName);
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

global $g_stock_sql;

function InitGlobalStockSql()
{
	global $g_stock_sql;
    $g_stock_sql = new StockSql();
}

function GetStockSql()
{
	global $g_stock_sql;
	return $g_stock_sql;
}

function GetStockHistorySql()
{
	global $g_stock_sql;
   	return $g_stock_sql->his_sql;
}

function GetNavHistorySql()
{
	global $g_stock_sql;
   	return $g_stock_sql->nav_sql;
}

function GetHoldingsSql()
{
	global $g_stock_sql;
   	return $g_stock_sql->holdings_sql;
}

function GetStockEmaSql($iDays)
{
	global $g_stock_sql;
	if ($iDays == 50)		return $g_stock_sql->ema50_sql;
	return $g_stock_sql->ema200_sql;
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

function SqlGetHisByDate($strStockId, $strDate)
{
	$his_sql = GetStockHistorySql();
	return $his_sql->GetClose($strStockId, $strDate);
}

function SqlGetNavByDate($strStockId, $strDate)
{
	$nav_sql = GetNavHistorySql();
	return $nav_sql->GetClose($strStockId, $strDate);
}

function SqlGetNav($strStockId)
{
	$nav_sql = GetNavHistorySql();
	return $nav_sql->GetCloseNow($strStockId);
}

function SqlGetUscny()
{
	return floatval(SqlGetNav(SqlGetStockId('USCNY')));
}

function SqlGetHkcny()
{
	return floatval(SqlGetNav(SqlGetStockId('HKCNY')));
}

function SqlGetUshkd()
{
	return SqlGetUscny() / SqlGetHkcny(); 
}

function SqlCountHoldings($strSymbol)
{
	$holdings_sql = GetHoldingsSql();
	return $holdings_sql->Count(SqlGetStockId($strSymbol));
}

function SqlGetHoldingsSymbolArray($strSymbol)
{
   	$arSymbol = array();
	if (SqlCountHoldings($strSymbol) > 0)
	{
		$sql = GetStockSql();
		$strStockId = $sql->GetId($strSymbol);
		$holdings_sql = GetHoldingsSql();
    	$ar = $holdings_sql->GetHoldingsArray($strStockId);
    	foreach ($ar as $strId => $strRatio)
    	{
    		$arSymbol[] = $sql->GetKey($strId);
    	}
    }
   	return $arSymbol;
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
