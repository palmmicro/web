<?php
require_once('sqlkeylog.php');

class WeixinSql extends KeyNameSql
{
    function WeixinSql($strUser = false)
    {
        parent::KeyNameSql(TABLE_WEIXIN, $strUser, 'user');
    }

    function Create()
    {
    	$str = ' `user` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL ,'
	          . ' `member_id` INT UNSIGNED NOT NULL ,'
	          . ' FOREIGN KEY (`member_id`) REFERENCES `member`(`id`) ON DELETE CASCADE ,'
          	  . ' UNIQUE ( `user` )';
        return $this->CreateKeyNameTable($str);
    }

    function _makeUpdateArray($strMemberId = '0')
    {
    	return array('member_id' => $strMemberId);
    }
    
    function MakeInsertArray()
    {
    	return array_merge($this->MakeKeyArray(), $this->_makeUpdateArray());
    }
    
    function UpdateUser($strUser, $strMemberId = '0')
    {
    	if ($record = $this->GetRecord($strUser))
    	{	
    		if ($record['member_id'] != $strMemberId)
    		{
    			return $this->UpdateById($this->_makeUpdateArray($strMemberId), $record['id']);
    		}
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
    function WeixinTextSql($strText = false)
    {
        parent::KeyNameSql(TABLE_WEIXIN_TEXT, $strText);
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
