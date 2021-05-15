<?php
require_once('sqlkeytable.php');

class CalibrationSql extends DailyKeySql
{
    function CalibrationSql() 
    {
        parent::DailyKeySql(TABLE_CALIBRATION);
    }

    public function Create()
    {
        return $this->CreateDailyKeyTable($this->ComposeTimeStr().','.$this->ComposeCloseStr());
    }
/*
    public function WriteDaily($strKeyId, $strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strKeyId, $strDate))
    	{
    		if ($record['close'] != $strClose)
    		{
    			return $this->UpdateDaily($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		return $this->InsertDaily($strKeyId, $strDate, $strClose);
    	}
    	return false;
    }

    function GetUniqueCloseArray($strKeyId)
    {
    	$ar = array();
    	if ($result = $this->GetAll($strKeyId)) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$arClose = explode(',', $record['close']);
    			$ar = array_merge($ar, array_unique($arClose));
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }
*/    
}

// ****************************** Stock Calibration tables *******************************************************

/*
function SqlCreateStockCalibrationTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stockcalibration` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `peername` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `price` DOUBLE(10,3) NOT NULL ,'
         . ' `peerprice` DOUBLE(10,3) NOT NULL ,'
         . ' `factor` DOUBLE(11,4) NOT NULL ,'
         . ' `filled` DATETIME NOT NULL ,'
         . ' UNIQUE ( `filled`, `stock_id` ),'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
}

function SqlAlterStockCalibrationTable()
{    
    $str = 'ALTER TABLE `camman`.`stockcalibration` ADD '
         . ' UNIQUE ( `filled`, `stock_id` )';
}
*/

function SqlUpdateStockCalibration($strStockId, $strPeerName, $strPrice, $strPeerPrice, $strFactor, $strDateTime)
{
	$strQry = "UPDATE stockcalibration SET peername = '$strPeerName', price = '$strPrice', peerprice = '$strPeerPrice', factor = '$strFactor' WHERE stock_id = '$strStockId' AND filled = '$strDateTime' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockcalibration table failed');
}

function SqlInsertStockCalibration($strStockId, $strPeerName, $strPrice, $strPeerPrice, $fFactor, $strDateTime)
{
    if (empty($fFactor) == false)
    {
        $strFactor = strval($fFactor);
        
        // check if record already exist
		if (SqlGetSingleTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhereAndArray(array('stock_id' => $strStockId, 'filled' => $strDateTime))))
        {
            return SqlUpdateStockCalibration($strStockId, $strPeerName, $strPrice, $strPeerPrice, $strFactor, $strDateTime);
        }
        
        $strQry = "INSERT INTO stockcalibration(id, stock_id, peername, price, peerprice, factor, filled) VALUES('0', '$strStockId', '$strPeerName', '$strPrice', '$strPeerPrice', '$strFactor', '$strDateTime')";
       	return SqlDieByQuery($strQry, 'Insert stockcalibration table failed');
	}
	return false;
}

function SqlCountStockCalibration($strStockId)
{
    return SqlCountTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhere_stock($strStockId));
}

function SqlGetStockCalibration($strStockId, $iStart, $iNum)
{
    return SqlGetTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhere_stock($strStockId), '`filled` DESC', _SqlBuildLimit($iStart, $iNum));
}

function SqlGetStockCalibrationNow($strStockId)
{
	if ($result = SqlGetStockCalibration($strStockId, 0, 1))
	{
	    $record = mysql_fetch_assoc($result);
	    return $record;
	}
	return false;
}

function SqlGetStockCalibrationTime($strStockId)
{
    if ($record = SqlGetStockCalibrationNow($strStockId))
    {
        return $record['filled']; 
    }
    return '';
}

function SqlGetStockCalibrationFactor($strStockId)
{
    if ($record = SqlGetStockCalibrationNow($strStockId))
    {
        return floatval($record['factor']); 
    }
    return false;
}

?>
