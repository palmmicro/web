<?php
require_once('sqlval.php');

class DateSql extends ValSql
{
    function DateSql($strTableName)
    {
        parent::ValSql($strTableName, 'date');
    }

    public function Create()
    {
    	$str = $this->ComposePrimaryIdStr().','
         	  . $this->ComposeDateStr();
    	return $this->CreateTable($str);
    }
    
    function WriteDate($strId, $strDate)
    {
    	return $this->WriteVal($strId, $strDate, true);
    }
    
    function ReadDate($strId)
    {
    	return $this->ReadVal($strId, true);
    }
}

class HoldingsDateSql extends DateSql
{
    function HoldingsDateSql()
    {
        parent::DateSql('holdingsdate');
    }
}

class NavFileDateSql extends DateSql
{
    function NavFileDateSql()
    {
        parent::DateSql('navfiledate');
    }
}

?>
