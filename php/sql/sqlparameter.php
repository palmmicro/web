<?php

// ****************************** Parameter table *******************************************************

function SqlCreateParameterTable($strTableName)
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`'
         . $strTableName
         . '` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `parameter` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' UNIQUE ( `parameter` (255) )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create spiderparameter table failed');
}

function SqlInsertParameter($strTableName, $strParameter)
{
	$strQry = 'INSERT INTO '.$strTableName."(id, parameter) VALUES('0', '$strParameter')";
	return SqlDieByQuery($strQry, $strTableName.' insert parameter failed');
}

function SqlGetParameter($strTableName, $strId)
{
    if ($record = SqlGetTableDataById($strTableName, $strId))
    {
		return $record['parameter'];
	}
	return false;
}

function SqlGetParameterId($strTableName, $strParameter)
{
	if ($record = SqlGetUniqueTableData($strTableName, _SqlBuildWhere('parameter', $strParameter)))
    {
		return $record['id'];
	}
	return false;
}

// ****************************** Parameter support functions *******************************************************

function MustGetParameterId($strTableName, $strParameter)
{
    SqlCreateParameterTable($strTableName);
    $strId = SqlGetParameterId($strTableName, $strParameter);
    if ($strId == false)
    {
        SqlInsertParameter($strTableName, $strParameter);
        $strId = SqlGetParameterId($strTableName, $strParameter);
    }
    return $strId;
}

?>
