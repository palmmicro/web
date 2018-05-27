<?php

// ****************************** SqlTable class *******************************************************
class SqlTable
{
	var $strName;
	
    // constructor 
    function SqlTable($strTableName) 
    {
    	$this->strName = $strTableName;
    }
    
    function Create($str)
    {
    	return SqlCreateTable($this->strName, $str);
    }
    
    function Insert($str)
    {
    	return SqlInsertTableData($this->strName, $str);
    }
    
    function Update($str)
    {
    	return SqlUpdateTableData($this->strName, $str);
    }
    
    function Count($strWhere = false)
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
    
    function Delete($strWhere, $strLimit = false)
    {
    	return SqlDeleteTableData($this->strName, $strWhere, $strLimit);
    }

    function DeleteById($strId)
    {
        return SqlDeleteTableDataById($this->strName, $strId);
    }
}

?>
