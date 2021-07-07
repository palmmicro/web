<?php
require_once('sqldailyclose.php');

class DailyStringSql extends DailyCloseSql
{
    function DailyStringSql($strTableName, $strKeyPrefix = TABLE_STOCK) 
    {
        parent::DailyCloseSql($strTableName, $strKeyPrefix);
    }

    public function Create()
    {
        return $this->CreateDailyCloseTable(' `close` VARCHAR( 8192 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ');
    }

    public function WriteDaily($strKeyId, $strDate, $strClose)
    {
    	if ($record = $this->GetRecord($strKeyId, $strDate))
    	{
    		if ($record['close'] != $strClose)
    		{
    			return $this->UpdateDaily($record['id'], $strClose);
    		}
    	}
    	else
    	{
    		return $this->InsertDaily($strKeyId, $strDate, $strClose);
    	}
    	return false;
    }

    function GetUniqueCloseArray($strKeyId)
    {
    	$ar = array();
    	if ($result = $this->GetAll($strKeyId)) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$arClose = explode(',', $record['close']);
    			$ar = array_merge($ar, array_unique($arClose));
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }
}

class AnnualIncomeSql extends DailyStringSql
{
    function AnnualIncomeSql() 
    {
        parent::DailyStringSql('annualincomestr');
    }
}

class QuarterIncomeSql extends DailyStringSql
{
    function QuarterIncomeSql() 
    {
        parent::DailyStringSql('quarterincomestr');
    }
}

?>
