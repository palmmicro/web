<?php
require_once('sqlval.php');

class DateSql extends ValSql
{
    public function __construct($strTableName)
    {
        parent::__construct($strTableName, 'date');
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

class StockHistoryDateSql extends DateSql
{
    public function __construct()
    {
        parent::__construct('stockhistorydate');
    }
}

class HoldingsDateSql extends DateSql
{
    public function __construct()
    {
        parent::__construct('holdingsdate');
    }
}

class NavFileDateSql extends DateSql
{
    public function __construct()
    {
        parent::__construct('navfiledate');
    }
}

?>
