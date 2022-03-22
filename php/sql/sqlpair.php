<?php
require_once('sqlint.php');

class PairSql extends IntSql
{
    function PairSql($strTableName, $strIdName = 'stock')
    {
        parent::IntSql($strTableName, $this->Add_id($strIdName));
    }

    public function Create()
    {
    	return $this->CreateIntTable(', '.$this->ComposeForeignStr($this->GetValName()));
    }
    
    function WritePair($strId, $strPairId)
    {
    	return $this->WriteInt($strId, $strPairId);
    }
    
    function ReadPair($strId)
    {
    	return $this->ReadInt($strId);
    }
}

class SecondaryListingSql extends PairSql
{
    function SecondaryListingSql()
    {
        parent::PairSql('secondarylisting');
    }
}

?>
