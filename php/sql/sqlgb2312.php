<?php
require_once('sqltable.php');

class GB2312Sql extends TableSql
{
    function GB2312Sql() 
    {
        parent::TableSql('gb2312');
    }
    
    function Create()
    {
    	$str = ' `id` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL PRIMARY KEY,'
         	  . ' `utf` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL';
    	return $this->CreateTable($str);
    }
    
    function Insert($strGB, $strUTF)
    {
    	return $this->InsertData(array('id' => $strGB, 'utf' => $strUTF));
    }
    
    function GetUTF($strGB)
    {
    	if ($record = $this->GetById($strGB))
    	{
    		return $record['utf'];
    	}
    	return false;
    }
}

?>
