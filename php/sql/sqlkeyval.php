<?php
require_once('sqlkeytable.php');

class KeyValSql extends KeyTableSql
{
	var $iMaxLen;
	var $strValName;
	
    function KeyValSql($strTableName, $strKeyId, $strKeyPrefix, $strValName = 'val', $iMaxValLen = 32)
    {
        $this->iMaxLen = $iMaxValLen;
        $this->strValName = $strValName;
        parent::KeyTableSql($strTableName, $strKeyId, $strKeyPrefix);
    }

    function Create()
    {
    	$str = $this->ComposeKeyStr().','
    		  . ' `'.$this->strValName.'` VARCHAR( '.strval($this->iMaxLen).' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	  . $this->ComposeForeignKeyStr().','
         	  . ' UNIQUE ( `'.$this->strValName.'`, `'.$this->strKey.'` )';
    	return $this->CreateIdTable($str);
    }
    
    function GetRecord($strVal)
    {
    	return $this->GetSingleData($this->BuildWhere_key_extra($this->strValName, $strVal));
    }

    function BuildOrderBy()
    {
    	return '`'.$this->strValName.'` ASC';
    }
    
/*    function GetAll()
    {
    	return $this->GetData($this->BuildWhere_key(), '`'.$this->strValName.'` ASC');
    }*/
    
    function Insert($strVal)
    {
    	$ar = $this->MakeFieldKeyId();
    	$ar[$this->strValName] = $strVal;
    	return $this->InsertArray($ar);
    }
    
    function Update($strId, $strVal)
    {
		return $this->UpdateById(array($this->strValName => $strVal), $strId);
    }
    
    function GetVal($strId)
    {
    	if ($record = $this->GetRecordById($strId))
    	{
    		return $record[$this->strValName];
    	}
    	return false;
    }
}

?>
