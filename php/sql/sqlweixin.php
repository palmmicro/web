<?php

// ****************************** Weixin image table *******************************************************

function SqlCreateWeixinImageTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`weixinimage` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `open_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `time` TIME NOT NULL ,'
         . ' FOREIGN KEY (`open_id`) REFERENCES `weixin`(`id`) ON DELETE CASCADE'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create weixinimage table failed');
}

function SqlInsertWeixinImage($strOpenId)
{
    list($strDate, $strTime) = explodeDebugDateTime();
	$strQry = "INSERT INTO weixinimage(id, open_id, date, time) VALUES('0', '$strOpenId', '$strDate', '$strTime')";
	return SqlDieByQuery($strQry, 'Insert weixinimage failed');
}

function SqlGetWeixinImage($strOpenId, $iStart, $iNum)
{
    return SqlGetTableData('weixinimage', _SqlBuildWhere('open_id', $strOpenId), _SqlOrderByDateTime(), _SqlBuildLimit($iStart, $iNum));
}

function SqlGetWeixinImageNow($strOpenId)
{
	if ($result = SqlGetWeixinImage($strOpenId, 0, 1))
	{
	    $record = mysql_fetch_assoc($result);
	    return $record['id'];
	}
	return false;
}

// ****************************** Weixin openid table *******************************************************
define ('TABLE_WEIXIN', 'weixin');

function SqlCreateWeixinTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`weixin` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `open` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' `union_id` INT UNSIGNED NOT NULL ,'
         . ' `member_id` INT UNSIGNED NOT NULL ,'
         . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
         . ' INDEX ( `union_id` ),'
         . ' UNIQUE ( `open` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create weixin table failed');
}

function SqlInsertWeixin($strOpenId)
{
	$strQry = "INSERT INTO weixin(id, open, union_id, member_id) VALUES('0', '$strOpenId', '0', '0')";
	return SqlDieByQuery($strQry, 'Insert weixin failed');
}

function SqlGetWeixin($strId)
{
    if ($record = SqlGetTableDataById(TABLE_WEIXIN, $strId))
    {
		return $record['open'];
	}
	return false;
}

function SqlGetWeixinId($strOpenId)
{
	if ($record = SqlGetUniqueTableData(TABLE_WEIXIN, _SqlBuildWhere('open', $strOpenId)))
    {
		return $record['id'];
	}
	return false;
}

// ****************************** Weixin openid table support functions *******************************************************

function MustGetWeixinId($strOpenId)
{
    SqlCreateWeixinTable();
    $strId = SqlGetWeixinId($strOpenId);
    if ($strId == false)
    {
        SqlInsertWeixin($strOpenId);
        $strId = SqlGetWeixinId($strOpenId);
    }
    return $strId;
}

?>
