<?php
require_once('sqlstocktransaction.php');

// ****************************** Stock Group table *******************************************************
/*
function SqlCreateStockGroupTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stockgroup` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `member_id` INT UNSIGNED NOT NULL ,'
         . ' `groupname` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `groupname`, `member_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	$result = @mysql_query($str);
	if (!$result)	die('Create stockgroup table failed');
}
*/

function SqlUpdateStockGroup($strStockGroupId, $strGroupName)
{
	$strQry = "UPDATE stockgroup SET groupname = '$strGroupName' WHERE id = '$strStockGroupId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockgroup failed');
}

function SqlGetStockGroupName($strStockGroupId)
{
    if ($stockgroup = SqlGetTableDataById(TABLE_STOCK_GROUP, $strStockGroupId))
	{
		return $stockgroup['groupname'];
	}
	return false;
}

function SqlGetStockGroupId($strGroupName, $strMemberId)
{
	if ($stockgroup = SqlGetSingleTableData(TABLE_STOCK_GROUP, _SqlBuildWhereAndArray(array('groupname' => $strGroupName, 'member_id' => $strMemberId))))
	{
	    return $stockgroup['id'];
	}
	return false;
}

function SqlInsertStockGroup($strMemberId, $strGroupName)
{
	$strQry = "INSERT INTO stockgroup(id, member_id, groupname) VALUES('0', '$strMemberId', '$strGroupName')";
	return SqlDieByQuery($strQry, 'Insert stockgroup failed');
}

function SqlGetStockGroupById($strGroupId)
{
    return SqlGetTableDataById(TABLE_STOCK_GROUP, $strGroupId);
}

function SqlGetStockGroupMemberId($strGroupId)
{
    if ($group = SqlGetStockGroupById($strGroupId))
    {
        return $group['member_id'];
    }
    return false;
}

function SqlGetStockGroupByMemberId($strMemberId)
{
    return SqlGetTableData(TABLE_STOCK_GROUP, _SqlBuildWhere_member($strMemberId), '`groupname` ASC');
}

// ****************************** Stock Group Item table *******************************************************
/*
function SqlCreateStockGroupItemTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stockgroupitem` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `group_id` INT UNSIGNED NOT NULL ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `quantity` INT NOT NULL ,'
         . ' `cost` DOUBLE(10,3) NOT NULL ,'
         . ' `record` INT NOT NULL ,'
         . ' INDEX ( `record` ),'
         . ' FOREIGN KEY (`group_id`) REFERENCES `stockgroup`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `stock_id`, `group_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	$result = @mysql_query($str);
	if (!$result)	die('Create stockgroupitem table failed');
}

function SqlAlterStockGroupItemTable()
{    
    $str = 'ALTER TABLE `camman`.`stockgroupitem` ADD '
         . ' INDEX ( `record` )';
//         . ' `quantity` INT DEFAULT \'0\'';
//         . ' `cost` DOUBLE(10,3) DEFAULT \'0.0\'';
//         . ' `filled` DATETIME DEFAULT \'2014-11-13 08:55:00\'';
//         . ' `record` INT DEFAULT \'0\'';
	$result = @mysql_query($str);
	if (!$result)	die('Alter stockgroupitem table failed');
}
*/

function SqlInsertStockGroupItem($strGroupId, $strStockId)
{
	$strQry = "INSERT INTO stockgroupitem(id, group_id, stock_id, quantity, cost, record) VALUES('0', '$strGroupId', '$strStockId', '0', '0.0', '0')";
	return SqlDieByQuery($strQry, 'Insert stockgroupitem failed');
}

function SqlUpdateStockGroupItem($strStockGroupItemId, $strQuantity, $strCost, $strRecord)
{
	$strQry = "UPDATE stockgroupitem SET quantity = '$strQuantity', cost = '$strCost', record = '$strRecord' WHERE id = '$strStockGroupItemId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockgroupitem failed');
}

function SqlGetStockGroupItemId($strGroupId, $strStockId)
{
	if ($stockgroupitem = SqlGetSingleTableData(TABLE_STOCK_GROUP_ITEM, _SqlBuildWhereAndArray(array('group_id' => $strGroupId, 'stock_id' => $strStockId))))
	{
	    return $stockgroupitem['id'];
	}
	return false;
}

function SqlGetStockGroupItemById($strGroupItemId)
{
    return SqlGetTableDataById(TABLE_STOCK_GROUP_ITEM, $strGroupItemId);
}

function SqlGetStockGroupItemByGroupId($strGroupId)
{
    return SqlGetTableData(TABLE_STOCK_GROUP_ITEM, _SqlBuildWhere('group_id', $strGroupId));
}

function SqlCountStockGroupItemByStockId($strStockId)
{
    return SqlCountTableData(TABLE_STOCK_GROUP_ITEM, _SqlBuildWhere_stock($strStockId));
}

// ****************************** Stock Group Item functions *******************************************************

function SqlDeleteStockGroupItem($strId)
{
    SqlDeleteStockTransactionByGroupItemId($strId);
    SqlDeleteTableDataById(TABLE_STOCK_GROUP_ITEM, $strId);
}

// ****************************** Stock Group functions *******************************************************

function SqlGetStockGroupItemArray($strGroupId)
{
	if ($result = SqlGetStockGroupItemByGroupId($strGroupId))
	{
	    $ar = array();
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
    		$ar[] = $stockgroupitem['id'];
		}
		@mysql_free_result($result);
        return $ar;
	}
	return false;
}

function SqlGetStockGroupItemSymbolArray($strGroupId)
{
	if ($result = SqlGetStockGroupItemByGroupId($strGroupId))
	{
	    $ar = array();
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
    		$ar[$stockgroupitem['id']] = SqlGetStockSymbol($stockgroupitem['stock_id']);
		}
		@mysql_free_result($result);
		asort($ar);
        return $ar;
	}
	return false;
}

function SqlGetStockGroupPrefetchSymbolArray($strGroupId)
{
    $arSymbol = array();
    if ($result = SqlGetStockGroupItemByGroupId($strGroupId))
	{
        while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    if (intval($stockgroupitem['record']) > 0)
		    {
		        $arSymbol[] = SqlGetStockSymbol($stockgroupitem['stock_id']);
		    }        
		}
		@mysql_free_result($result);
	}
	return $arSymbol;
}

function SqlGetStockGroupArray($strStockGroupId)
{
	if ($result = SqlGetStockGroupItemByGroupId($strStockGroupId))
	{
	    $ar = array();
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    $strStockId = $stockgroupitem['stock_id'];
		    if ($strSymbol = SqlGetStockSymbol($strStockId))
		    {
		    	$ar[$strStockId] = $strSymbol;
		    }
		}
		@mysql_free_result($result);
		asort($ar);
		return $ar;
	}
	return false;
}

function SqlGetStocksArray($strStockGroupId)
{
    $ar = array();
    $arStockIdName = SqlGetStockGroupArray($strStockGroupId);
    foreach ($arStockIdName as $strId => $strSymbol)
    {
        $ar[] = $strSymbol;
    }
    return $ar;
}

function SqlDeleteStockGroupByMemberId($strMemberId)
{
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    SqlDeleteStockGroup($stockgroup['id']);
		}
		@mysql_free_result($result);
	}
}

function SqlDeleteStockGroupItemByGroupId($strGroupId)
{
	if ($result = SqlGetStockGroupItemByGroupId($strGroupId))
	{
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    SqlDeleteStockGroupItem($stockgroupitem['id']);
		}
		@mysql_free_result($result);
	}
}

function SqlDeleteStockGroup($strGroupId)
{
    SqlDeleteStockGroupItemByGroupId($strGroupId);
    SqlDeleteTableDataById(TABLE_STOCK_GROUP, $strGroupId);
}

function SqlDeleteStockGroupByGroupName($strGroupName)
{
    $strWhere = _SqlBuildWhere('groupname', $strGroupName);
    $iCount = SqlCountTableData(TABLE_STOCK_GROUP, $strWhere);
    DebugVal($iCount, 'GroupName: '.$strGroupName.' total');
    if ($iCount == 0)   return true;
    
    if ($result = SqlGetTableData(TABLE_STOCK_GROUP, $strWhere))
    {
        while ($stockgroup = mysql_fetch_assoc($result)) 
        {
            SqlDeleteStockGroupItemByGroupId($stockgroup['id']);
        }
        @mysql_free_result($result);
    }
    return SqlDeleteTableData(TABLE_STOCK_GROUP, $strWhere);
}

?>
