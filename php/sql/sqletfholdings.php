<?php
require_once('sqlkey.php');

class EtfHoldingsSql extends KeySql
{
    function EtfHoldingsSql() 
    {
        parent::KeySql(TABLE_ETF_HOLDINGS, TABLE_STOCK);
    }

    public function Create()
    {
    	$str = $this->ComposeKeyStr().','
    		  . $this->ComposeIdStr('holding_id').','
         	  . ' `ratio` DOUBLE(13,6) NOT NULL ,'
         	  . $this->ComposeForeignKeyStr();
    	return $this->CreateIdTable($str);
    }

    public function BuildOrderBy()
    {
    	return '`ratio` DESC';
    }
    
    function InsertHolding($strStockId, $strHoldingId, $strRatio)
    {
    	return $this->InsertArrays($this->MakeFieldKeyId($strStockId), array('holding_id' => $strHoldingId, 'ratio' => $strRatio));
    }
    
    function GetHoldingsArray($strStockId)
    {
    	$ar = array();
    	if ($result = $this->GetAll($strStockId)) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strHoldingId = $record['holding_id']; 
    			$ar[$strHoldingId] = $record['ratio'];
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }
}

?>
