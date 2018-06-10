<?php

// ****************************** TableSql class *******************************************************
class TableSql
{
	var $strName;
	
    // constructor 
    function TableSql($strTableName) 
    {
    	$this->strName = $strTableName;
    }

    function _query($strQuery, $strDie)
    {
    	DebugString($strQuery);
        return SqlDieByQuery($strQuery, $this->strName.' '.$strDie);
	}
	
    function CreateTable($str)
    {
    	$strQuery = 'CREATE TABLE IF NOT EXISTS `camman`.`'
        	 . $this->strName
        	 . '` ('
        	 . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
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
    
    function InsertData($str)
    {
	    $strQuery = 'INSERT INTO '.$this->strName.$str;
        return $this->_query($strQuery, 'insert data failed');
    }
    
    function UpdateData($str, $strWhere, $strLimit = false)
    {
    	$strQuery = 'UPDATE '.$this->strName.' SET '.$str._SqlAddWhere($strWhere)._SqlAddLimit($strLimit);
        return $this->_query($strQuery, 'update data failed');
    }
    
    function UpdateById($str, $strId)
    {
    	if ($strWhere = _SqlBuildWhere_id($strId))
    	{
    		return $this->UpdateData($str, $strWhere, '1');
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

    function GetSingleData($strWhere = false, $strOrderBy = false)
    {
    	return SqlGetSingleTableData($this->strName, $strWhere, $strOrderBy);
    }

    function GetById($strId)
    {
    	return $this->GetSingleData(_SqlBuildWhere_id($strId));
    }
    
    function GetTableIdCallback($strVal, $callback)
    {
    	if ($record = $this->$callback($strVal))
    	{
    		return $record['id'];
    	}
    	return false;
    }
    
    function DeleteData($strWhere, $strLimit = false)
    {
    	return SqlDeleteTableData($this->strName, $strWhere, $strLimit);
    }

    function DeleteById($strId)
    {
    	if ($strWhere = _SqlBuildWhere_id($strId))
    	{
    		return $this->DeleteData($strWhere, '1');
    	}
    	return false;
    }

    function DeleteInvalidDate()
    {
    	$ar = array();
    	if ($result = $this->GetAll()) 
    	{
    		while ($history = mysql_fetch_assoc($result)) 
    		{
    			$ymd = new OldestYMD();
    			if ($ymd->IsInvalid($history['date']))
    			{
    				$ar[] = $history['id'];
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
}

// ****************************** KeyTableSql class *******************************************************
class KeyTableSql extends TableSql
{
	var $strKey;
	var $strKeyId;
	
    function BuildWhere_key_extra($strKey, $strVal)
    {
		return _SqlBuildWhereAndArray(array($this->strKey => $this->strKeyId, $strKey => $strVal));
    }
    
    function BuildWhere_key_stock($strStockId)
    {
		return $this->BuildWhere_key_extra('stock_id', $strStockId);
    }
    
    function BuildWhere_key()
    {
    	return _SqlBuildWhere($this->strKey, $this->strKeyId);
    }
    
    function GetKeyId()
    {
    	return $this->strKeyId;
    }
    
    function KeyTableSql($strKeyId, $strKeyPrefix, $strTableName) 
    {
    	$this->strKeyId = $strKeyId;
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
