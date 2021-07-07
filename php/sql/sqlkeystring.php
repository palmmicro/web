<?php
require_once('sqlkey.php');

class KeyStringSql extends KeySql
{
	var $iMaxStringLen;
	var $strStringName;
	
    function KeyStringSql($strTableName, $strKeyPrefix = TABLE_MEMBER, $strStringName = 'str', $iMaxStringLen = 32) 
    {
        $this->iMaxStringLen = $iMaxStringLen;
        $this->strStringName = $strStringName;
        
        parent::KeySql($strTableName, $strKeyPrefix);
    }

    public function Create()
    {
    	$str = $this->ComposeKeyStr().','
    		  . ' `'.$this->strStringName.'` VARCHAR( '.strval($this->iMaxStringLen).' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	  . $this->ComposeForeignKeyStr().','
         	  . ' UNIQUE ( `'.$this->strStringName.'`, `'.$this->GetKeyIndex().'` )';
    	return $this->CreateIdTable($str);
    }
    
    public function BuildOrderBy()
    {
    	return '`'.$this->strStringName.'` ASC';
    }
    
    function BuildWhere_key_string($strKeyId, $strString)
    {
		return $this->BuildWhere_key_ex($strKeyId, $this->strStringName, $strString);
    }
    
    function GetRecord($strKeyId, $strString)
    {
    	return $this->GetSingleData($this->BuildWhere_key_string($strKeyId, $strString));
    }
    
    function GetRecordId($strKeyId, $strString)
    {
		if ($record = $this->GetRecord($strKeyId, $strString))
		{
			return $record['id'];
    	}
    	return false;
    }
    
    function InsertString($strKeyId, $strString)
    {
        if ($this->GetRecord($strKeyId, $strString))	return false;
        
    	$ar = $this->MakeFieldKeyId($strKeyId);
    	$ar[$this->strStringName] = $strString;
    	return $this->InsertArray($ar);
    }

    function UpdateString($strId, $strString)
    {
		return $this->UpdateById(array($this->strStringName => $strString), $strId);
    }
    
    function GetString($strId)
    {
    	if ($record = $this->GetRecordById($strId))
    	{
    		return $record[$this->strStringName];
    	}
    	return false;
    }
}

class CommonPhraseSql extends KeyStringSql
{
    function CommonPhraseSql() 
    {
        parent::KeyStringSql(TABLE_COMMON_PHRASE);
    }
}

?>
