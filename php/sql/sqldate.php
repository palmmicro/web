<?php
require_once('sqltable.php');

class DateSql extends TableSql
{
    function DateSql($strTableName)
    {
        parent::TableSql($strTableName);
    }

    public function Create()
    {
    	$str = $this->ComposePrimaryIdStr().','
         	  . $this->ComposeDateStr();
    	return $this->CreateTable($str);
    }
    
    function Insert($strId, $strDate)
    {
    	return $this->InsertArray(array('id' => $strId, 'date' => $strDate));
    }

    function Update($strId, $strDate)
    {
		return $this->UpdateById(array('date' => $strDate), $strId);
    }
    
    function WriteDate($strId, $strDate)
    {
   		if ($record = $this->GetRecordById($strId))
   		{
			if ($strDate != $record['date'])
			{
				return $this->Update($strId, $strDate);
			}
			return false;
   		}
    	return $this->Insert($strId, $strDate);
    }
    
    function ReadDate($strId)
    {
   		if ($record = $this->GetRecordById($strId))
   		{
			return $record['date'];
   		}
    	return false;
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
