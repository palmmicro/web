<?php
require_once('sqlkey.php');

class EtfHoldingsSql extends KeySql
{
    function EtfHoldingsSql() 
    {
        parent::KeySql('etfholdings', TABLE_STOCK);
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
}

?>
