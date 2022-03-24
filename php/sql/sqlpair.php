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
    
    private function _buildWhere($strPairId)
    {
    	return _SqlBuildWhere($this->GetValName(), $strPairId);
    }
    
    public function GetRecord($strPairId)
    {
    	return $this->GetSingleData($this->_buildWhere($strPairId));
    }
    
    public function GetAll($strPairId)
    {
    	return $this->GetData($this->_buildWhere($strPairId));
    }
    
    function Delete($strPairId)
    {
    	return $this->DeleteData($this->_buildWhere($strPairId));
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

?>
