<?php
require_once('sqlkeyname.php');

class PageSql extends KeyNameSql
{
    public function __construct()
    {
        parent::__construct(TABLE_PAGE, 'uri');
    }

    function GetPageUri($strPageId)
    {
    	return $this->GetKey($strPageId);
	}
}

class PageCommentSql extends VisitorSql
{
	var $strIpKey;
	
    public function __construct()
    {
    	$this->strIpKey = $this->Add_id('ip');
        parent::__construct(TABLE_PAGE_COMMENT, TABLE_PAGE, TABLE_MEMBER);
    }

    public function Create()
    {
    	$str = '`comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
    		 . $this->ComposeIdStr($this->strIpKey).','
    		 . $this->ComposeForeignStr($this->strIpKey).',';
    	return $this->CreateVisitorTable($str);
    }
    
    function _addCommentArray(&$ar, $strComment, $strIp = false)
    {
    	$ar['comment'] = $strComment;
    	$ar[$this->strIpKey] = GetIpId($strIp ? $strIp : UrlGetIp());
    }
    
    function InsertPageComment($strPageId, $strMemberId, $strComment, $strIp = false, $strDate = false, $strTime = false)
    {
    	$ar = $this->MakeVisitorInsertArray($strPageId, $strMemberId, $strDate, $strTime);
    	$this->_addCommentArray($ar, $strComment, $strIp);
    	return $this->InsertArray($ar);
    }

    function UpdatePageComment($strId, $strComment)
    {
    	$ar = $this->MakeDateTimeArray();
    	$this->_addCommentArray($ar, $strComment);
		return $this->UpdateById($ar, $strId);
	}

    function BuildWhereByIp($strIp)
    {
    	return _SqlBuildWhere($this->strIpKey, GetIpId($strIp));
    }
}

// ****************************** Blog Comment table *******************************************************
        
function SqlDeleteBlogCommentByMemberId($strMemberId)
{
    return SqlDeleteTableData(TABLE_PAGE_COMMENT, _SqlBuildWhere_member($strMemberId));
}

?>
