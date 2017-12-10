<?php

// ****************************** Spider Parameter table *******************************************************

function SqlCreateSpiderParameterTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`spiderparameter` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `parameter` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' UNIQUE ( `parameter` (255) )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create spiderparameter table failed');
}

function SqlInsertSpiderParameter($strParameter)
{
	$strQry = "INSERT INTO spiderparameter(id, parameter) VALUES('0', '$strParameter')";
	return SqlDieByQuery($strQry, 'Insert spiderparameter failed');
}

function SqlGetSpiderParameter($strId)
{
    if ($record = SqlGetTableDataById('spiderparameter', $strId))
    {
		return $record['parameter'];
	}
	return false;
}

function SqlGetSpiderParameterId($strParameter)
{
	$strQry = "SELECT * FROM spiderparameter WHERE parameter = '$strParameter' LIMIT 1";
    if ($record = SqlQuerySingleRecord($strQry, 'Query spiderparameter id failed'))
    {
		return $record['id'];
	}
	return false;
}

// ****************************** Spider Parameter support functions *******************************************************

function MustGetSpiderParameterId($strParameter)
{
    SqlCreateSpiderParameterTable();
    $strId = SqlGetSpiderParameterId($strParameter);
    if ($strId == false)
    {
        SqlInsertSpiderParameter($strParameter);
        $strId = SqlGetSpiderParameterId($strParameter);
    }
    return $strId;
}

?>
