<?php
require_once('sqltable.php');

class DateSql extends TableSql
{
    function DateSql($strTableName)
    {
        parent::TableSql($strTableName);
    }

    function Create()
    {
    	$str = $this->ComposePrimaryIdStr().','
         	  . $this->ComposeDateStr();
    	return $this->CreateTable($str);
    }
}

class EtfHoldingsDateSql extends DateSql
{
    function EtfHoldingsDateSql()
    {
        parent::DateSql('etfholdingsdate');
    }
}

?>
