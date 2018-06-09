<?php
require_once('sqltable.php');
require_once('sqlstocktransaction.php');

// ****************************** StockGroupSql class *******************************************************
class StockGroupSql extends MemberTableSql
{
    function StockGroupSql($strMemberId) 
    {
        parent::MemberTableSql($strMemberId, TABLE_STOCK_GROUP);
    }
    
    function Get($strGroupName)
    {
    	return $this->GetSingleData($this->BuildWhere_id_extra('groupname', $strGroupName));
    }
    
    function GetTableId($strGroupName)
    {
		return $this->GetTableIdCallback($strGroupName, 'Get');
    }

    function GetAll()
    {
    	return $this->GetData($this->BuildWhere_id(), '`groupname` ASC');
    }
    
    function Insert($strGroupName)
    {
    	$strMemberId = $this->GetId(); 
    	return $this->InsertData("(id, member_id, groupname) VALUES('0', '$strMemberId', '$strGroupName')");
    }
    
    function Update($strId, $strGroupName)
    {
		return $this->UpdateById("groupname = '$strGroupName'", $strId);
    }
}

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

function SqlGetStockGroupById($strGroupId)
{
    return SqlGetTableDataById(TABLE_STOCK_GROUP, $strGroupId);
}

function SqlGetStockGroupName($strGroupId)
{
    if ($group = SqlGetStockGroupById($strGroupId))
    {
        return $group['groupname'];
    }
	return false;
}

function SqlGetStockGroupMemberId($strGroupId)
{
    if ($group = SqlGetStockGroupById($strGroupId))
    {
        return $group['member_id'];
    }
    return false;
}

// ****************************** StockGroupItemSql class *******************************************************
class StockGroupItemSql extends StockGroupTableSql
{
	var $trans_sql;	// StockTransactionSql
	
    function StockGroupItemSql($strStockGroupId) 
    {
        parent::StockGroupTableSql($strStockGroupId, TABLE_STOCK_GROUP_ITEM);
        $this->trans_sql = new StockTransactionSql();
    }

    function Get($strStockId)
    {
    	return $this->GetSingleData($this->BuildWhere_id_stock($strStockId));
    }
    
    function GetTableId($strStockId)
    {
		return $this->GetTableIdCallback($strStockId, 'Get');
    }

    function Insert($strStockId)
    {
    	$strGroupId = $this->GetId(); 
    	return $this->InsertData("(id, group_id, stock_id, quantity, cost, record) VALUES('0', '$strGroupId', '$strStockId', '0', '0.0', '0')");
    }

    function GetStockIdArray($bCheckTransaction = false)
    {
    	if ($result = $this->GetAll())
    	{
    		$ar = array();
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			if ($bCheckTransaction)
    			{
    				if (intval($record['record']) == 0)		continue;
    			}
    			$ar[$record['id']] = $record['stock_id'];
    		}
    		@mysql_free_result($result);
    		return $ar;
    	}
    	return false;
    }
    
    function BuildWhere_groupitem($strGroupItemId)
    {
    	return _SqlBuildWhere('groupitem_id', $strGroupItemId);
    }
    
    function DeleteStockTransaction($strGroupItemId)
    {
    	$this->trans_sql->Delete($this->BuildWhere_groupitem($strGroupItemId));
    }

    function CountStockTransaction($strStockId)
    {
    	if ($strGroupItemId = $this->GetTableId($strStockId))
    	{
    		return $this->trans_sql->Count($this->BuildWhere_groupitem($strGroupItemId));
    	}
    	return 0;
    }

    function GetStockTransaction($strStockId, $iStart = 0, $iNum = 0)
    {
    	if ($strId = $this->GetTableId($strStockId))
    	{
    		return $this->trans_sql->Get($strId, $iStart, $iNum);
    	}
    	return false;
    }
    
    function CountAllStockTransaction()
    {
    	if ($ar = $this->GetTableIdArray())
    	{
   			return $this->trans_sql->CountAll($ar);
    	}
    	return 0;
    }
    
    function GetAllStockTransaction($iStart = 0, $iNum = 0)
    {
    	if ($ar = $this->GetTableIdArray())
    	{
    		return $this->trans_sql->GetAll($ar, $iStart, $iNum);
    	}
    	return false;
    }
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

function SqlUpdateStockGroupItem($strStockGroupItemId, $strQuantity, $strCost, $strRecord)
{
	$strQry = "UPDATE stockgroupitem SET quantity = '$strQuantity', cost = '$strCost', record = '$strRecord' WHERE id = '$strStockGroupItemId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockgroupitem failed');
}

function SqlGetStockGroupItemById($strGroupItemId)
{
    return SqlGetTableDataById(TABLE_STOCK_GROUP_ITEM, $strGroupItemId);
}

// ****************************** Stock Group functions *******************************************************
function SqlGetStockGroupItemSymbolArray($sql)
{
    if ($arStockId = $sql->GetStockIdArray())
    {
    	$ar = array();
    	foreach ($arStockId as $str => $strStockId)
    	{
    		$ar[$str] = SqlGetStockSymbol($strStockId);
    	}
		asort($ar);
    	return $ar;
    }
    return false;
}

function SqlGetStocksArray($strGroupId, $bCheckTransaction = false)
{
    $ar = array();
	$sql = new StockGroupItemSql($strGroupId);
    if ($arStockId = $sql->GetStockIdArray($bCheckTransaction))
    {
    	foreach ($arStockId as $str => $strStockId)
    	{
    		$ar[] = SqlGetStockSymbol($strStockId);
    	}
    }
	sort($ar);
    return $ar;
}

function SqlGroupHasStock($strGroupId, $strStockId, $bCheckTransaction = false)
{
	$sql = new StockGroupItemSql($strGroupId);
    if ($arStockId = $sql->GetStockIdArray($bCheckTransaction))
    {
    	return array_search($strStockId, $arStockId);
    }
    return false;
}

function SqlDeleteStockGroupByMemberId($strMemberId)
{
	$sql = new StockGroupSql($strMemberId);
	if ($result = $sql->GetAll()) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    SqlDeleteStockGroupItemByGroupId($stockgroup['id']);
		}
		@mysql_free_result($result);
	}
	$sql->DeleteAll();
}

function SqlDeleteStockGroupItemByGroupId($strGroupId)
{
	$sql = new StockGroupItemSql($strGroupId);
	if ($result = $sql->GetAll())
	{
		while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
            $sql->DeleteStockTransaction($stockgroupitem['id']);
		}
		@mysql_free_result($result);
		$sql->DeleteAll();
	}
}

function SqlDeleteStockGroupByGroupName($strGroupName)
{
	$sql = new TableSql(TABLE_STOCK_GROUP);
    $strWhere = _SqlBuildWhere('groupname', $strGroupName);
    $iCount = $sql->Count($strWhere);
    DebugVal($iCount, 'GroupName: '.$strGroupName.' total');
    if ($iCount == 0)   return true;
    
    if ($result = $sql->GetData($strWhere))
    {
        while ($stockgroup = mysql_fetch_assoc($result)) 
        {
            SqlDeleteStockGroupItemByGroupId($stockgroup['id']);
        }
        @mysql_free_result($result);
    }
    return $sql->Delete($strWhere);
}

function SqlUpdateStockGroup($strGroupId, $arNew)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arOld = array();
    if ($arStockId = $sql->GetStockIdArray())
    {
    	foreach ($arStockId as $str => $strStockId)
    	{
    		$arOld[] = $strStockId;
    	}
    }
    
    foreach ($arNew as $strStockId)
	{
	    if (in_array($strStockId, $arOld) == false)
	    {
	    	$sql->Insert($strStockId);
	    }
	}
	
    foreach ($arOld as $strStockId)
	{
	    if (in_array($strStockId, $arNew) == false)
	    {
            $strId = $sql->GetTableId($strStockId);
            $sql->DeleteStockTransaction($strId);
            $sql->DeleteById($strId);
	    }
	}
}

?>
