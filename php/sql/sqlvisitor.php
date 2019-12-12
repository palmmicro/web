<?php

// ****************************** Visitor tables *******************************************************

define('VISITOR_TABLE', 'visitor');
define('WEIXIN_VISITOR_TABLE', 'weixinvisitor');

function SqlCreateVisitorTable($strTableName)
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`'
         . $strTableName
         . '` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `dst_id` INT UNSIGNED NOT NULL ,'
         . ' `src_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `time` TIME NOT NULL ,'
         . ' INDEX (`dst_id`) ,'
         . ' INDEX (`src_id`)'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, $strTableName.' create table failed');
}

function SqlInsertVisitor($strTableName, $strDstId, $strSrcId)
{
    if ($strDstId == false)    return false;
    
    $strDate = DebugGetDate();
    $strTime = DebugGetTime();
	$strQry = 'INSERT INTO '.$strTableName."(id, dst_id, src_id, date, time) VALUES('0', '$strDstId', '$strSrcId', '$strDate', '$strTime')";
	return SqlDieByQuery($strQry, $strTableName.' insert visitor failed');
}

function SqlCountVisitor($strTableName, $strSrcId)
{
    return SqlCountTableData($strTableName, _SqlBuildWhere('src_id', $strSrcId));
}

function SqlGetVisitor($strTableName, $strSrcId, $iStart, $iNum)
{
    return SqlGetTableData($strTableName, _SqlBuildWhere('src_id', $strSrcId), _SqlOrderByDateTime(), _SqlBuildLimit($iStart, $iNum));
}

function SqlDeleteVisitor($strTableName, $strSrcId)
{
    if ($strSrcId)
    {
        return SqlDeleteTableData($strTableName, _SqlBuildWhere('src_id', $strSrcId));
    }
    return false;
}

?>
