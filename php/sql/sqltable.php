<?php

class TableSql
{
	var $strName;
	
    function TableSql($strTableName) 
    {
    	$this->strName = $strTableName;
        $this->Create();
    }

    function GetTableName()
    {
    	return $this->strName;
    }
    
    function ComposeIdStr()
    {
    	return ' `id` INT UNSIGNED NOT NULL PRIMARY KEY';
    }

    function Create()
    {
    	return $this->CreateTable($this->ComposeIdStr());
    }
    
    function CreateIdTable($str)
    {
       	return $this->CreateTable(' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'.$str);
    }

    function _query($strQuery, $strDie)
    {
//    	DebugString($strQuery);
        return SqlDieByQuery($strQuery, $this->strName.' ['.$strQuery.'] '.$strDie);
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

    // ALTER TABLE这个写法每次只能加一个
    function AlterTable($str)
    {
    	$strQuery = 'ALTER TABLE `camman`.`'
        	 . $this->strName
        	 . '` ADD '
        	 . $str;
        return $this->_query($strQuery, 'alter table failed');
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

    function GetRecordById($strId)
    {
    	return $this->GetSingleData(_SqlBuildWhere_id($strId));
    }
    
    function GetId($strVal, $callback = 'GetRecord')
    {
    	if ($strVal !== false)
    	{
    		if (method_exists($this, $callback))
    		{
    			if ($record = $this->$callback($strVal))
    			{
    				return $record['id'];
    			}
    		}
    	}
    	return false;
    }
    
    function GetIdArray($callback = 'GetAll')
    {
    	if (method_exists($this, $callback))
    	{
    		if ($result = $this->$callback())
    		{
    			$ar = array();
    			while ($record = mysql_fetch_assoc($result)) 
    			{
    				$ar[] = $record['id'];
    			}
    			@mysql_free_result($result);
    			return $ar;
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

    function DeleteInvalid($callback)
    {
    	$ar = array();
    	if ($result = $this->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			if ($this->$callback($record))
    			{
    				$ar[] = $record['id'];
    			}
    		}
    		@mysql_free_result($result);
    	}

    	$iCount = count($ar);
    	if ($iCount > 0)
    	{
    		foreach ($ar as $strId)
    		{
    			$this->DeleteById($strId);
    		}
    	}
    	return $iCount;
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

?>
