<?php
require_once('sqlval.php');

class IntSql extends ValSql
{
    function IntSql($strTableName, $strIntName = 'num')
    {
        parent::ValSql($strTableName, $strIntName);
    }

    public function Create()
    {
    	$str = $this->ComposePrimaryIdStr().','
         	  . $this->ComposeIdStr($this->GetValName());
    	return $this->CreateTable($str);
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
    function FundArbitrageSql()
    {
        parent::IntSql('fundarbitrage');
    }
}

?>
