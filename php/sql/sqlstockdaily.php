<?php
require_once('sqlstocktable.php');
require_once('sqlstocksymbol.php');

// ****************************** SqlStockDaily class *******************************************************
class SqlStockDaily extends SqlStockTable
{
    // constructor 
    function SqlStockDaily($strStockId, $strTableName) 
    {
        parent::SqlStockTable($strStockId, $strTableName);
        $this->Create();
    }
    
    function Create()
    {
    	$str = ' `stock_id` INT UNSIGNED NOT NULL ,'
         	  . ' `date` DATE NOT NULL ,'
         	  . ' `close` DOUBLE(13,6) NOT NULL ,'
         	  . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `date`, `stock_id` )';
    	return parent::Create($str);
    }

    function GetByDate($strDate)
    {
    	return SqlGetUniqueTableData($this->strName, $this->_buildWhere_date_stock($strDate));
    }
    
    function GetCloseStringByDate($strDate)
    {
    	if ($record = $this->GetByDate($strDate))
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetCloseByDate($strDate)
    {
    	if ($str = $this->GetCloseStringByDate($strDate))
    	{
    		return floatval($str);
    	}
    	return false;
    }

    function GetNow()
    {
    	return SqlGetSingleTableData($this->strName, $this->_buildWhere_stock(), _SqlOrderByDate());
    }
    
    function GetCloseStringNow()
    {
    	if ($record = $this->GetNow())
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetCloseNow()
    {
    	if ($str = $this->GetCloseStringNow())
    	{
    		return floatval($str);
    	}
    	return false;
    }
}

function SqlGetStockDailyPrev($strTableName, $strStockId, $strDate)
{
	return SqlGetSingleTableData($strTableName, "stock_id = '$strStockId' AND date < '$strDate'", _SqlOrderByDate());
}

function SqlCountStockDaily($strTableName, $strStockId)
{
    return SqlCountTableData($strTableName, _SqlBuildWhere_stock($strStockId));
}

function SqlGetStockDailyAll($strTableName, $strStockId, $iStart, $iNum)
{
    return SqlGetTableData($strTableName, _SqlBuildWhere_stock($strStockId), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
}

function SqlInsertStockDaily($strTableName, $strStockId, $strDate, $strClose)
{
	$strQry = "INSERT INTO $strTableName(id, stock_id, date, close) VALUES('0', '$strStockId', '$strDate', '$strClose')";
	return SqlDieByQuery($strQry, $strTableName.' insert data failed');
}

function SqlUpdateStockDaily($strTableName, $strStockId, $strDate, $strClose)
{
	$strQry = "UPDATE $strTableName SET close = '$strClose' WHERE stock_id = '$strStockId' AND date = '$strDate' LIMIT 1";
	return SqlDieByQuery($strQry, $strTableName.' update data failed');
}

// ****************************** SqlStockEma class *******************************************************
class SqlStockEma extends SqlStockDaily
{
    // constructor 
    function SqlStockEma($strStockId, $iDays) 
    {
        parent::SqlStockDaily($strStockId, 'stockema'.strval($iDays));
    }
}

// ****************************** SqlEtfCalibration class *******************************************************
class SqlEtfCalibration extends SqlStockDaily
{
    // constructor 
    function SqlEtfCalibration($strStockId)
    {
        parent::SqlStockDaily($strStockId, TABLE_ETF_CALIBRATION);
    }
}

// ****************************** ETF Calibration table *******************************************************
function SqlGetEtfCalibrationPrev($strStockId, $strDate)
{
	return SqlGetStockDailyPrev(TABLE_ETF_CALIBRATION, $strStockId, $strDate);
}

function SqlCountEtfCalibration($strStockId)
{
    return SqlCountStockDaily(TABLE_ETF_CALIBRATION, $strStockId);
}

function SqlGetEtfCalibrationAll($strStockId, $iStart, $iNum)
{
    return SqlGetStockDailyAll(TABLE_ETF_CALIBRATION, $strStockId, $iStart, $iNum);
}

function SqlInsertEtfCalibration($strStockId, $strDate, $strClose)
{
	return SqlInsertStockDaily(TABLE_ETF_CALIBRATION, $strStockId, $strDate, $strClose);
}

// ****************************** SqlForexHistory class *******************************************************
class SqlForexHistory extends SqlStockDaily
{
    // constructor 
    function SqlForexHistory($strStockId) 
    {
        parent::SqlStockDaily($strStockId, TABLE_FOREX_HISTORY);
    }
}

class SqlUscnyHistory extends SqlForexHistory
{
    // constructor 
    function SqlUscnyHistory() 
    {
        parent::SqlForexHistory(SqlGetStockId('USCNY'));
    }
}

class SqlHkcnyHistory extends SqlForexHistory
{
    // constructor 
    function SqlHkcnyHistory() 
    {
        parent::SqlForexHistory(SqlGetStockId('HKCNY'));
    }
}

// ****************************** Forex History table *******************************************************
function SqlGetForexHistoryPrev($strStockId, $strDate)
{
	return SqlGetStockDailyPrev(TABLE_FOREX_HISTORY, $strStockId, $strDate);
}

function SqlInsertForexHistory($strStockId, $strDate, $strClose)
{
	return SqlInsertStockDaily(TABLE_FOREX_HISTORY, $strStockId, $strDate, $strClose);
}

// ****************************** Forex Support Functions *******************************************************
function SqlGetForexHistoryNow($strStockId)
{
	$forex = new SqlForexHistory($strStockId);
	return $forex->GetNow();
}

function SqlGetHKCNY()
{
	$hkcny = new SqlHkcnyHistory();
	return $hkcny->GetCloseNow();
}

function SqlGetUSCNY()
{
	$uscny = new SqlUscnyHistory();
	return $uscny->GetCloseNow();
}

?>
