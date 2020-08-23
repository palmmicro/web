<?php
require_once('sqlkeyname.php');
require_once('sqlvisitor.php');

class PageSql extends KeyNameSql
{
    function PageSql($strUri = false)
    {
        parent::KeyNameSql(TABLE_PAGE, 'uri', $strUri);
    }
}

class PageCommentSql extends VisitorSql
{
	var $strIpKey;
	
    function PageCommentSql()
    {
    	$this->strIpKey = $this->Add_id(TABLE_IP);
        parent::VisitorSql(TABLE_PAGE_COMMENT, TABLE_PAGE, TABLE_MEMBER);
    }

    public function GetExtraCreateStr()
    {
    	$str = '`comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
    		 . $this->ComposeIdStr($this->strIpKey).','
    		 . $this->ComposeForeignStr($this->strIpKey).',';
    	return $str;
    }

    function _addCommentArray(&$ar, $strComment, $strIpId)
    {
    	$ar['comment'] = $strComment;
    	$ar[$this->strIpKey] = $strIpId;
    }
    
    function InsertPageComment($strPageId, $strMemberId, $strComment, $strIpId, $strDate = false, $strTime = false)
    {
    	$ar = $this->MakeVisitorInsertArray($strPageId, $strMemberId, $strDate, $strTime);
    	$this->_addCommentArray(&$ar, $strComment, $strIpId);
    	return $this->InsertArray($ar);
    }

    function UpdatePageComment($strId, $strComment, $strIpId)
    {
    	$ar = $this->MakeDateTimeArray();
    	$this->_addCommentArray(&$ar, $strComment, $strIpId);
		return $this->UpdateById($ar, $strId);
	}

    function BuildWhereByIp($strIpId)
    {
    	return _SqlBuildWhere($this->strIpKey, $strIpId);
    }
}

// ****************************** Blog Comment table *******************************************************
        
function SqlDeleteBlogCommentByMemberId($strMemberId)
{
    return SqlDeleteTableData(TABLE_PAGE_COMMENT, _SqlBuildWhere_member($strMemberId));
}

?>
