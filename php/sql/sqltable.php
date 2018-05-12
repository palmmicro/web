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
    
    function Count($strWhere)
    {
    	return SqlCountTableData($this->strName, $strWhere);
    }

    function GetData($strWhere, $strOrderBy, $strLimit)
    {
    	return SqlGetTableData($this->strName, $strWhere, $strOrderBy, $strLimit);
    }

    function GetAllData()
    {
    	return $this->GetData(false, false, false);
    }
    
    function GetSingleData($strWhere, $strOrderBy)
    {
    	return SqlGetSingleTableData($this->strName, $strWhere, $strOrderBy);
    }
    
    function GetUniqueData($strWhere)
    {
    	if ($strWhere)
    	{
    		return $this->GetSingleData($strWhere, false);
    	}
    	return false;
    }
    
    function Delete($strWhere, $strLimit)
    {
    	return SqlDeleteTableData($this->strName, $strWhere, $strLimit);
    }

    function DeleteById($strId)
    {
        return SqlDeleteTableDataById($this->strName, $strId);
    }
}

?>
