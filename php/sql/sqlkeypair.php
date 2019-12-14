<?php
require_once('sqlkeytable.php');

class KeyPairSql extends KeyTableSql
{
    function KeyPairSql($strTableName, $strKeyId, $strKeyPrefix)
    {
        parent::KeyTableSql($strTableName, $strKeyId, $strKeyPrefix);
    }

    function Create()
    {
    	$str = $this->ComposeIdStr().','
    		  . $this->ComposeKeyStr().','
         	  . $this->ComposeForeignKeyStr();
    	return $this->CreateTable($str);
    }
    
    function Insert($strId, $strPairId)
    {
    	return $this->InsertData(array('id' => $strId, $this->strKey => $strPairId));
    }

    function Update($strId, $strPairId)
    {
		return $this->UpdateById(array($this->strKey => $strPairId), $strId);
    }
    
    function GetRecord($strPairId)
    {
    	return $this->GetSingleData(_SqlBuildWhere($this->strKey, $strPairId));
    }

    function Delete($strPairId)
    {
    	return $this->DeleteData(_SqlBuildWhere($this->strKey, $strPairId));
    }
}

?>
