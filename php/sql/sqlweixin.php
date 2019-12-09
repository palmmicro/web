<?php
require_once('sqltable.php');

// ****************************** WeixinSql class *******************************************************
class WeixinSql extends KeyNameSql
{
    function WeixinSql()
    {
        parent::KeyNameSql('weixin', 'user');
    }

    function Create()
    {
    	$str = ' `user` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
	          . ' `member_id` INT UNSIGNED NOT NULL ,'
	          . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
          	  . ' UNIQUE ( `user` )';
    	return $this->CreateIdTable($str);
    }
    
    function WriteUser($strUser, $strMemberId = '0')
    {
    	$ar = array('user' => $strUser,
    				  'member_id' => $strMemberId);
    	
    	if ($record = $this->GetRecord($strUser))
    	{	
    		unset($ar['user']);
    		if ($record['member_id'] == $strMemberId)		unset($ar['member_id']);
    		if (count($ar) > 0)
    		{
    			return $this->UpdateById($ar, $record['id']);
    		}
    	}
    	else
    	{
    		return $this->InsertData($ar);
    	}
    	return false;
    }

    function InsertUser($strUser)
    {
    	if ($this->GetRecord($strUser) == false)
    	{
    		return $this->WriteUser($strUser);
    	}
    	return false;
    }
}

?>
