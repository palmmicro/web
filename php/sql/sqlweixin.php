<?php
require_once('sqlkeylog.php');

class WeixinSql extends KeyNameSql
{
    function WeixinSql()
    {
        parent::KeyNameSql(TABLE_WEIXIN, 'user');
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

class WeixinVisitorSql extends KeyLogSql
{
    function WeixinVisitorSql($strUser)
    {
        parent::KeyLogSql(TABLE_WEIXIN_VISITOR, $strUser, TABLE_WEIXIN, TABLE_WEIXIN_TEXT);
    }
}

class WeixinTextSql extends KeyNameSql
{
    function WeixinTextSql()
    {
        parent::KeyNameSql(TABLE_WEIXIN_TEXT);
    }
    
    function IsUnused($record)
    {
    	return false;
    }
    
    function DeleteUnused()
    {
    	return $this->DeleteInvalid('IsUnused');
    }
}

?>
