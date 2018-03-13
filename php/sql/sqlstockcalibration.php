<?php

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
	$result = @mysql_query($str);
	if (!$result)	die('Create stockcalibration table failed');
}

function SqlAlterStockCalibrationTable()
{    
    $str = 'ALTER TABLE `camman`.`stockcalibration` ADD '
         . ' UNIQUE ( `filled`, `stock_id` )';
	$result = @mysql_query($str);
	if (!$result)	die('Alter stockcalibration table failed');
}
*/

function SqlUpdateStockCalibration($strStockId, $strPeerName, $strPrice, $strPeerPrice, $strFactor, $strDateTime)
{
	$strQry = "UPDATE stockcalibration SET peername = '$strPeerName', price = '$strPrice', peerprice = '$strPeerPrice', factor = '$strFactor' WHERE stock_id = '$strStockId' AND filled = '$strDateTime' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockcalibration table failed');
}

function SqlInsertStockCalibration($strStockId, $strPeerName, $strPrice, $strPeerPrice, $fFactor, $strDateTime)
{
    if (FloatNotZero($fFactor))
    {
        $strFactor = strval($fFactor);
        
        // check if record already exist
		if (SqlGetUniqueTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhereAndArray(array('stock_id' => $strStockId, 'filled' => $strDateTime))))
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
    return SqlCountTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhere('stock_id', $strStockId));
}

function SqlGetStockCalibration($strStockId, $iStart, $iNum)
{
    return SqlGetTableData(TABLE_STOCK_CALIBRATION, _SqlBuildWhere('stock_id', $strStockId), '`filled` DESC', _SqlBuildLimit($iStart, $iNum));
}

function SqlGetStockCalibrationNow($strStockId)
{
	if ($result = SqlGetStockCalibration($strStockId, 0, 1))
	{
	    $history = mysql_fetch_assoc($result);
	    return $history;
	}
	return false;
}

function SqlGetStockCalibrationTime($strStockId)
{
    if ($history = SqlGetStockCalibrationNow($strStockId))
    {
        return $history['filled']; 
    }
    return '';
}

function SqlGetStockCalibrationFactor($strStockId)
{
    if ($history = SqlGetStockCalibrationNow($strStockId))
    {
        return floatval($history['factor']); 
    }
    return false;
}

?>
