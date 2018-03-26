<?php

function SqlCreateGB2312Table()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`gb2312` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `gb` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `utf` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' UNIQUE ( `gb` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create gb2312 table failed');
}

function SqlInsertGB2312($strGB, $strUTF)
{
	$strQry = "INSERT INTO gb2312(id, gb, utf) VALUES('0', '$strGB', '$strUTF')";
	return SqlDieByQuery($strQry, 'Insert gb2312 failed');
}

function SqlGetUTF($strGB)
{
	if ($record = SqlGetUniqueTableData(TABLE_GB2312, _SqlBuildWhere('gb', $strGB)))
	{
        return $record['utf'];
	}
}

?>
