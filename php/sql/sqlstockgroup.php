<?php
//require_once('sqlkeytable.php');
require_once('sqlkeyval.php');
require_once('sqlstocktransaction.php');

// ****************************** StockGroupSql class *******************************************************
class StockGroupSql extends KeyValSql
{
    function StockGroupSql($strMemberId = false) 
    {
        parent::KeyValSql(TABLE_STOCK_GROUP, $strMemberId, TABLE_MEMBER, 'groupname', 64);
    }
}

// ****************************** StockGroupItemSql class *******************************************************
class StockGroupItemSql extends KeyTableSql
{
	var $trans_sql;	// StockTransactionSql
	
    function StockGroupItemSql($strGroupId = false) 
    {
        parent::KeyTableSql(TABLE_STOCK_GROUP_ITEM, $strGroupId, TABLE_STOCK_GROUP);
        $this->trans_sql = new StockTransactionSql();
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
    
    function GetStockId($strId)
    {
    	if ($record = $this->GetRecordById($strId))
    	{
    		return $record['stock_id'];
    	}
    	return false;
    }

    function GetRecord($strStockId)
    {
    	return $this->GetSingleData($this->BuildWhere_key_stock($strStockId));
    }

    function _makePrivateFieldArray($strQuantity = '0', $strCost = '0.0', $strRecord = '0')
    {
		return array('quantity' => $strQuantity, 'cost' => $strCost, 'record' => $strRecord);
    }
    
    function Insert($strStockId)
    {
    	return $this->InsertArray(array_merge($this->MakeFieldKeyId(), array('stock_id' => $strStockId), $this->_makePrivateFieldArray()));
    }

    function Update($strId, $strQuantity, $strCost, $strRecord)
    {
		return $this->UpdateById($this->_makePrivateFieldArray($strQuantity, $strCost, $strRecord), $strId);
	}
    
    function CountStockTransaction($strStockId)
    {
    	if ($strGroupItemId = $this->GetId($strStockId))
    	{
    		return $this->trans_sql->Count($strGroupItemId);
    	}
    	return 0;
    }

    function GetStockTransaction($strStockId, $iStart = 0, $iNum = 0)
    {
    	if ($strId = $this->GetId($strStockId))
    	{
    		return $this->trans_sql->GetRecord($strId, $iStart, $iNum);
    	}
    	return false;
    }
    
    function CountAllStockTransaction()
    {
    	if ($ar = $this->GetIdArray())
    	{
   			return $this->trans_sql->CountAll($ar);
    	}
    	return 0;
    }
    
    function GetAllStockTransaction($iStart = 0, $iNum = 0)
    {
    	if ($ar = $this->GetIdArray())
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
         . ' `stockgroup_id` INT UNSIGNED NOT NULL ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `quantity` INT NOT NULL ,'
         . ' `cost` DOUBLE(10,3) NOT NULL ,'
         . ' `record` INT NOT NULL ,'
         . ' INDEX ( `record` ),'
         . ' FOREIGN KEY (`stockgroup_id`) REFERENCES `stockgroup`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `stock_id`, `stockgroup_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
}

function SqlAlterStockGroupItemTable()
{    
    $str = 'ALTER TABLE `camman`.`stockgroupitem` ADD '
         . ' INDEX ( `record` )';
//         . ' `quantity` INT DEFAULT \'0\'';
//         . ' `cost` DOUBLE(10,3) DEFAULT \'0.0\'';
	$result = @mysql_query($str);
}
*/

function SqlGetStockGroupId($strGroupItemId)
{
    if ($record = SqlGetTableDataById(TABLE_STOCK_GROUP_ITEM, $strGroupItemId))
    {
    	return $record['stockgroup_id'];
    }
    return false;
}

// ****************************** Stock Group functions *******************************************************
function SqlGetStockGroupItemSymbolArray($sql)
{
    if ($arStockId = $sql->GetStockIdArray())
    {
    	$arA = array();
    	$arH = array();
    	$arUS = array();
     	foreach ($arStockId as $str => $strStockId)
    	{
    		$strSymbol = SqlGetStockSymbol($strStockId);
    		$sym = new StockSymbol($strSymbol);
    		if ($sym->IsTradable())
    		{
    			if ($sym->IsSymbolA())		$arA[$str] = $strSymbol;
    			else if ($sym->IsSymbolH())	$arH[$str] = $strSymbol;
    			else							$arUS[$str] = $strSymbol;
    		}
    	}
		asort($arA);
		asort($arH);
		asort($arUS);
        return $arA + $arH + $arUS;
//    	return array_merge($arA, $arH, $arUS);	// Can NOT use array_merge for all-digit keys
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
		while ($record = mysql_fetch_assoc($result)) 
		{
		    SqlDeleteStockGroupItemByGroupId($record['id']);
		}
		@mysql_free_result($result);
		$sql->DeleteAll();
	}
}

function SqlDeleteStockGroupItemByGroupId($strGroupId)
{
	$sql = new StockGroupItemSql($strGroupId);
	if ($result = $sql->GetAll())
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
            $sql->trans_sql->Delete($record['id']);
		}
		@mysql_free_result($result);
		$sql->DeleteAll();
	}
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
            $strId = $sql->GetId($strStockId);
            $sql->trans_sql->Delete($strId);
            $sql->DeleteById($strId);
	    }
	}
}

?>
