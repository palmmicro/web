<?php
require_once('sqlval.php');

class IntSql extends ValSql
{
    public function __construct($strTableName, $strIntName = 'num')
    {
        parent::__construct($strTableName, $strIntName);
    }

    function CreateIntTable($strExtra = '')
    {
    	$str = $this->ComposePrimaryIdStr().','
         	  . $this->ComposeIdStr($this->GetValName())
         	  . $strExtra;
    	return $this->CreateTable($str);
    }
    
    public function Create()
    {
    	return $this->CreateIntTable();
    }
    
    function WriteInt($strId, $strInt)
    {
    	return $this->WriteVal($strId, $strInt, true);
    }
    
    function ReadInt($strId)
    {
    	return $this->ReadVal($strId, true);
    }
}

class FundArbitrageSql extends IntSql
{
    public function __construct()
    {
        parent::__construct('fundarbitrage');
    }
}

?>
