<?php
require_once('sqltable.php');

class GB2312Sql extends TableSql
{
    function GB2312Sql() 
    {
        parent::TableSql('gb2312');
        $this->Create();
    }
    
    function Create()
    {
    	$str = ' `gb` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	  . ' `utf` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
         	  . ' UNIQUE ( `gb` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strGB, $strUTF)
    {
    	return $this->InsertData(array('gb' => $strGB, 'utf' => $strUTF));
    }
    
    function GetUTF($strGB)
    {
    	if ($record = $this->GetSingleData(_SqlBuildWhere('gb', $strGB)))
    	{
    		return $record['utf'];
    	}
    	return false;
    }
}

?>
