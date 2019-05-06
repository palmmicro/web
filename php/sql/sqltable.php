<?php

// ****************************** TableSql class *******************************************************
class TableSql
{
	var $strName;
	
    function TableSql($strTableName) 
    {
    	$this->strName = $strTableName;
        $this->Create();
    }

    function Create()
    {
    	return $this->CreateTable(' `id` INT UNSIGNED NOT NULL PRIMARY KEY');
    }
    
    function _query($strQuery, $strDie)
    {
//    	DebugString($strQuery);
        return SqlDieByQuery($strQuery, $this->strName.' ['.$strQuery.'] '.$strDie);
	}
	
    function CreateIdTable($str)
    {
       	return $this->CreateTable(' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'.$str);
    }

    function CreateTable($str)
    {
    	$strQuery = 'CREATE TABLE IF NOT EXISTS `camman`.`'
        	 . $this->strName
        	 . '` ('
        	 . $str
        	 . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
        return $this->_query($strQuery, 'create table failed');
    }

    function DropTable()
    {
    	$strQuery = 'DROP TABLE IF EXISTS `camman`.`'
        	. $this->strName
        	. '`';
        return $this->_query($strQuery, 'drop table failed');
    }
    
    function InsertData($ar)
    {
		if (array_key_exists('id', $ar))
		{
			$strKeyAll = '';
			$strValAll = '';
		}
		else
		{
			$strKeyAll = 'id, ';
			$strValAll = "'0', ";
		}
		
    	foreach ($ar as $strKey => $strVal)
    	{
    		$strKeyAll .= $strKey.', ';
    		$strValAll .= "'$strVal', ";
    	}
    	$strKeyAll = rtrim($strKeyAll, ', ');
    	$strValAll = rtrim($strValAll, ', ');
 		$strQuery = 'INSERT INTO '.$this->strName."($strKeyAll) VALUES($strValAll)";
        return $this->_query($strQuery, 'insert data failed');
    }
    
    function InsertId($strId)
    {
        return $this->InsertData(array('id' => $strId));
    }
    
    function UpdateData($ar, $strWhere, $strLimit = false)
    {
    	$str = '';
    	foreach ($ar as $strKey => $strVal)
    	{
    		$str .= _SqlBuildWhere($strKey, $strVal).', ';
    	}
    	$str = rtrim($str, ', ');
    	$strQuery = 'UPDATE '.$this->strName.' SET '.$str._SqlAddWhere($strWhere)._SqlAddLimit($strLimit);
        return $this->_query($strQuery, 'update data failed');
    }
    
    function UpdateById($ar, $strId)
    {
    	if ($strWhere = _SqlBuildWhere_id($strId))
    	{
    		return $this->UpdateData($ar, $strWhere, '1');
    	}
    	return false;
    }
    
    function CountData($strWhere = false)
    {
    	return SqlCountTableData($this->strName, $strWhere);
    }

    function GetData($strWhere = false, $strOrderBy = false, $strLimit = false)
    {
    	return SqlGetTableData($this->strName, $strWhere, $strOrderBy, $strLimit);
    }

    function GetByMaxId($iMax)
    {
    	$strMax = strval($iMax);
    	return $this->GetData("id <= '$strMax'", '`id` ASC');
    }
    
    function GetSingleData($strWhere = false, $strOrderBy = false)
    {
    	return SqlGetSingleTableData($this->strName, $strWhere, $strOrderBy);
    }

    function GetById($strId)
    {
    	return $this->GetSingleData(_SqlBuildWhere_id($strId));
    }
    
    function GetId($strVal, $callback = 'Get')
    {
    	if (method_exists($this, $callback))
    	{
    		if ($record = $this->$callback($strVal))
    		{
    			return $record['id'];
    		}
    	}
    	return false;
    }
    
    function DeleteData($strWhere, $strLimit = false)
    {
    	return SqlDeleteTableData($this->strName, $strWhere, $strLimit);
    }

    function DeleteCountData($strWhere)
    {
    	$iCount = $this->CountData($strWhere);
    	if ($iCount > 0)
    	{
    		DebugVal($iCount, 'DeleteCountData table '.$this->strName.' WHERE '.$strWhere);
    		$this->DeleteData($strWhere);
    	}
    }
    
    function DeleteById($strId)
    {
    	if ($strWhere = _SqlBuildWhere_id($strId))
    	{
    		return $this->DeleteData($strWhere);
    	}
    	return false;
    }

    function DeleteInvalidDate()
    {
    	$ar = array();
    	if ($result = $this->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ymd = new OldestYMD();
    			if ($ymd->IsInvalid($record['date']))
    			{
    				$ar[] = $record['id'];
    			}
    		}
    		@mysql_free_result($result);
    	}

    	$iCount = count($ar);
    	if ($iCount > 0)
    	{
    		DebugVal($iCount, $this->strName.' - invalid date'); 
    		foreach ($ar as $strId)
    		{
    			$this->DeleteById($strId);
    		}
    	}
    }
    
    function GetTableSchema()
    {
    	$strQry = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'camman' AND "._SqlBuildWhere('TABLE_NAME', $this->strName);
    	if ($result = mysql_query($strQry))
    	{
    		if (mysql_num_rows($result) > 0) 
    		{
    			return $result;
    		}
    	}
    	else
    	{
    		die_mysql_error($strQry.' query data failed');
    	}
    	return false;
    }
    
    function GetTableColumn()
    {
    	$ar = array();
    	if ($result = $this->GetTableSchema()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
   				$ar[] = $record['COLUMN_NAME'];
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }
}

// ****************************** KeyNameSql class *******************************************************
class KeyNameSql extends TableSql
{
	var $iMaxLen;
	var $strKeyName;
	
    function KeyNameSql($strTableName, $strKeyName, $iMaxKeyLen = 32)
    {
        $this->iMaxLen = $iMaxKeyLen;
        $this->strKeyName = $strKeyName;
        parent::TableSql($strTableName);
    }

    function Create()
    {
    	$str = ' `'.$this->strKeyName.'` VARCHAR( '.strval($this->iMaxLen).' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	. ' UNIQUE ( `'.$this->strKeyName.'` )';
    	return $this->CreateIdTable($str);
    }

    function Get($strKeyName)
    {
    	return $this->GetSingleData(_SqlBuildWhere($this->strKeyName, $strKeyName));
    }

    function GetAll($iStart = 0, $iNum = 0)
    {
   		return $this->GetData(false, '`'.$this->strKeyName.'` ASC', _SqlBuildLimit($iStart, $iNum));
    }
	
    function GetKeyName($strId)
    {
    	if ($record = $this->GetById($strId))
    	{
    		return $record[$this->strKeyName];
    	}
    	return false;
    }
}

// ****************************** KeyTableSql class *******************************************************
class KeyTableSql extends TableSql
{
	var $strKey;
	var $strKeyPrefix;
	var $strKeyId;
	
    function GetKeyId($strId = false)
    {
    	if ($strId)
    	{
    		if ($record = $this->GetById($strId))
    		{
    			return $record[$this->strKey];
    		}
    		return false;
    	}
    	return $this->strKeyId;
    }
    
    function GetFieldKeyId()
    {
    	return array($this->strKey => $this->strKeyId);
    }
    
    function BuildWhere_key()
    {
    	return _SqlBuildWhere($this->strKey, $this->strKeyId);
    }
    
    function BuildWhere_key_extra($strKey, $strVal)
    {
    	$ar = $this->GetFieldKeyId();
    	$ar[$strKey] = $strVal;
		return _SqlBuildWhereAndArray($ar);
    }
    
    function BuildWhere_key_stock($strStockId)
    {
		return $this->BuildWhere_key_extra('stock_id', $strStockId);
    }
    
    function KeyTableSql($strKeyId, $strKeyPrefix, $strTableName) 
    {
    	$this->strKeyId = $strKeyId;
    	$this->strKeyPrefix = $strKeyPrefix;
    	$this->strKey = $strKeyPrefix.'_id';
        parent::TableSql($strTableName);
    }
    
    function Count()
    {
    	return $this->CountData($this->BuildWhere_key());
    }
    
    function GetAll()
    {
    	return $this->GetData($this->BuildWhere_key());
    }

    function GetTableIdArray()
    {
    	if ($result = $this->GetAll())
    	{
    		$ar = array();
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ar[] = $record['id'];
    		}
    		@mysql_free_result($result);
    		return $ar;
    	}
    	return false;
    }
    
    function DeleteAll()
    {
    	return $this->DeleteData($this->BuildWhere_key());
    }  
}

// ****************************** KeyValSql class *******************************************************
class KeyValSql extends KeyTableSql
{
	var $iMaxLen;
	var $strValName;
	
    function KeyValSql($strKeyId, $strKeyPrefix, $strTableName, $strValName = 'val', $iMaxValLen = 32)
    {
        $this->iMaxLen = $iMaxValLen;
        $this->strValName = $strValName;
        parent::KeyTableSql($strKeyId, $strKeyPrefix, $strTableName);
    }

    function Create()
    {
    	$str = ' `'.$this->strKey.'` INT UNSIGNED NOT NULL ,'
    		  . ' `'.$this->strValName.'` VARCHAR( '.strval($this->iMaxLen).' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	  . ' FOREIGN KEY (`'.$this->strKey.'`) REFERENCES `'.$this->strKeyPrefix.'`(`id`) ON DELETE CASCADE ,'
         	  . ' UNIQUE ( `'.$this->strValName.'`, `'.$this->strKey.'` )';
    	return $this->CreateIdTable($str);
    }
    
    function Get($strVal)
    {
    	return $this->GetSingleData($this->BuildWhere_key_extra($this->strValName, $strVal));
    }

    function GetAll()
    {
    	return $this->GetData($this->BuildWhere_key(), '`'.$this->strValName.'` ASC');
    }
    
    function Insert($strVal)
    {
    	$ar = $this->GetFieldKeyId();
    	$ar[$this->strValName] = $strVal;
    	return $this->InsertData($ar);
    }
    
    function Update($strId, $strVal)
    {
		return $this->UpdateById(array($this->strValName => $strVal), $strId);
    }
    
    function GetVal($strId)
    {
    	if ($record = $this->GetById($strId))
    	{
    		return $record[$this->strValName];
    	}
    	return false;
    }
}

// ****************************** StockTableSql class *******************************************************
class StockTableSql extends KeyTableSql
{
    function BuildWhere_stock_date($strDate)
    {
		return $this->BuildWhere_key_extra('date', $strDate);
    }
    
    function StockTableSql($strStockId, $strTableName) 
    {
        parent::KeyTableSql($strStockId, 'stock', $strTableName);
    }
}

// ****************************** MemberTableSql class *******************************************************
class MemberTableSql extends KeyTableSql
{
    function MemberTableSql($strMemberId, $strTableName) 
    {
        parent::KeyTableSql($strMemberId, 'member', $strTableName);
    }
}

// ****************************** StockGroupTableSql class *******************************************************
class StockGroupTableSql extends KeyTableSql
{
    function StockGroupTableSql($strGroupId, $strTableName) 
    {
        parent::KeyTableSql($strGroupId, 'group', $strTableName);
    }
}

?>
