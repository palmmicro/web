<?php

// ****************************** Stock Calibration tables *******************************************************
function SqlCreateCalibrationTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`calibration` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `etfpair_id` INT UNSIGNED NOT NULL ,'
         . ' `factor` DOUBLE(13,6) NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' UNIQUE ( `date`, `etfpair_id` ),'
         . ' FOREIGN KEY (`etfpair_id`) REFERENCES `etfpair`(`id`) ON DELETE CASCADE'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create calibration table failed');
}

function SqlUpdateCalibration($strEtfPairId, $strFactor, $strDate)
{
	$strQry = "UPDATE calibration SET factor = '$strFactor' WHERE etfpair_id = '$strEtfPairId' AND date = '$strDate' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update calibration table failed');
}

function SqlInsertCalibration($strEtfPairId, $strFactor, $strDate)
{
    $strQry = "INSERT INTO calibration(id, etfpari_id, factor, date) VALUES('0', '$strEtfPairId', '$strFactor', '$strDate')";
	return SqlDieByQuery($strQry, 'Insert calibration table failed');
}

function SqlCountCalibration($strEtfPairId)
{
    return SqlCountTableData(TABLE_CALIBRATION, _SqlBuildWhere_etfpair($strEtfPairId));
}

function SqlGetCalibration($strEtfPairId, $iStart, $iNum)
{
    return SqlGetTableData(TABLE_CALIBRATION, _SqlBuildWhere_etfpair($strEtfPairId), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
}

function SqlGetCalibrationNow($strEtfPairId)
{
	return SqlGetSingleTableData(TABLE_CALIBRATION, _SqlBuildWhere_etfpair($strEtfPairId), _SqlOrderByDate());
}

function SqlGetCalibrationDate($strEtfPairId)
{
    if ($history = SqlGetCalibrationNow($strEtfPairId))
    {
        return $history['date']; 
    }
    return '';
}

function SqlGetCalibrationFactor($strEtfPairId)
{
    if ($history = SqlGetCalibrationNow($strEtfPairId))
    {
        return floatval($history['factor']); 
    }
    return false;
}

?>
