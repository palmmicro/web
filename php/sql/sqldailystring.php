<?php
require_once('sqldailyclose.php');

class DailyStringSql extends DailyCloseSql
{
    public function __construct($strTableName, $strKeyPrefix = 'stock') 
    {
        parent::__construct($strTableName, $strKeyPrefix);
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
}

?>
