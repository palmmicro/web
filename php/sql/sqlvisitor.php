<?php
require_once('sqltable.php');

class VisitorSql extends TableSql
{
	var $strDst;
	var $strSrc;
	
	var $strDstPrefix;
	var $strSrcPrefix;
	
    function VisitorSql($strTableName = TABLE_VISITOR, $strDstPrefix = TABLE_PAGE, $strSrcPrefix = TABLE_IP)
    {
        $this->strDstPrefix = $strDstPrefix;
        $this->strSrcPrefix = $strSrcPrefix;

    	$this->strDst = $strDstPrefix.'_id';
    	$this->strSrc = $strSrcPrefix.'_id';
        
        parent::TableSql($strTableName);
    }

    function GetExtraCreateStr()
    {
    	return '';
    }
    
    function Create()
    {
    	$str = ' `'.$this->strDst.'` INT UNSIGNED NOT NULL ,'
    		 . ' `'.$this->strSrc.'` INT UNSIGNED NOT NULL ,'
    		 . ' `date` DATE NOT NULL ,'
    		 . ' `time` TIME NOT NULL ,'
    		 . $this->GetExtraCreateStr()
    		 . ' FOREIGN KEY (`'.$this->strDst.'`) REFERENCES `'.$this->strDstPrefix.'`(`id`) ON DELETE CASCADE ,'
    		 . ' FOREIGN KEY (`'.$this->strSrc.'`) REFERENCES `'.$this->strSrcPrefix.'`(`id`) ON DELETE CASCADE ';
    	return $this->CreateIdTable($str);
    }

    function Insert($strDstId, $strSrcId, $strDate = false, $strTime = false)
    {
    	$ar = array($this->strDst => $strDstId, $this->strSrc => $strSrcId);
    	$ar['date'] = $strDate ? $strDate : DebugGetDate();
    	$ar['time'] = $strTime ? $strTime : DebugGetTime();
    	return $this->InsertArray($ar);
    }

    function _buildWhereBySrc($strSrcId)
    {
    	return _SqlBuildWhere($this->strSrc, $strSrcId);
    }
    
    function GetDataBySrc($strSrcId, $iStart, $iNum)
    {
    	return $this->GetData($this->_buildWhereBySrc($strSrcId), _SqlOrderByDateTime(), _SqlBuildLimit($iStart, $iNum));
    }

    function DeleteBySrc($strSrcId)
    {
    	if ($strSrcId)
    	{
    		return $this->DeleteRecord($this->_buildWhereBySrc($strSrcId));
    	}
    	return false;
    }
    
    function CountBySrc($strSrcId)
    {
    	return $this->CountData($this->_buildWhereBySrc($strSrcId));
    }

    function CountByDate($strDate)
    {
    	return $this->CountData(_SqlBuildWhere('date', $strDate));
    }

    function CountToday()
    {
    	return $this->CountByDate(DebugGetDate());
    }
}

// ****************************** Visitor tables *******************************************************
/*
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
*/
?>
