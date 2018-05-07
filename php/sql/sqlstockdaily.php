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

    function Get($strDate)
    {
    	return SqlGetUniqueTableData($this->strName, $this->BuildWhere_date_stock($strDate));
    }
    
    function GetCloseString($strDate)
    {
    	if ($record = $this->Get($strDate))
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetClose($strDate)
    {
    	if ($str = $this->GetCloseString($strDate))
    	{
    		return floatval($str);
    	}
    	return false;
    }

    function GetPrev($strDate)
    {
    	return SqlGetSingleTableData($this->strName, $this->BuildWhere_stock()." AND date < '$strDate'", _SqlOrderByDate());
    }

    function GetPrevCloseString($strDate)
    {
    	if ($record = $this->GetPrev($strDate))
    	{
    		return $record['close'];
    	}
    	return false;
    }

    function GetNow()
    {
    	return SqlGetSingleTableData($this->strName, $this->BuildWhere_stock(), _SqlOrderByDate());
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

    function Count()
    {
    	return SqlCountTableData($this->strName, $this->BuildWhere_stock());
    }

    function GetAll($iStart, $iNum)
    {
    	return SqlGetTableData($this->strName, $this->BuildWhere_stock(), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
    }
    
    function Insert($strDate, $strClose)
    {
    	$strTableName = $this->strName;
    	$strStockId = $this->GetStockId(); 
    	$strQry = "INSERT INTO $strTableName(id, stock_id, date, close) VALUES('0', '$strStockId', '$strDate', '$strClose')";
    	return SqlDieByQuery($strQry, $strTableName.' insert data failed');
    }

    function Update($strDate, $strClose)
    {
    	$strTableName = $this->strName;
    	$strStockId = $this->GetStockId(); 
    	$strQry = "UPDATE $strTableName SET close = '$strClose' WHERE stock_id = '$strStockId' AND date = '$strDate' LIMIT 1";
    	return SqlDieByQuery($strQry, $strTableName.' update data failed');
    }
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

// ****************************** Forex Support Functions *******************************************************
function SqlGetForexHistoryNow($strStockId)
{
	$sql = new SqlForexHistory($strStockId);
	return $sql->GetNow();
}

function SqlGetHKCNY()
{
	$sql = new SqlHkcnyHistory();
	return $sql->GetCloseNow();
}

function SqlGetUSCNY()
{
	$sql = new SqlUscnyHistory();
	return $sql->GetCloseNow();
}

?>
