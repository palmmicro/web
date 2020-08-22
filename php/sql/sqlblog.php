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
    function PageCommentSql()
    {
        parent::VisitorSql(TABLE_PAGE_COMMENT, TABLE_PAGE, TABLE_MEMBER);
    }

    public function GetExtraCreateStr()
    {
    	$str = '`comment` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
    		 . $this->ComposeIdStr('ip_id').','
    		 . 'INDEX ( `ip_id` ) ,';
    	return $str;
    }

    function InsertPageComment($strPageId, $strMemberId, $strComment, $strIpId, $strDate = false, $strTime = false)
    {
    	$ar = $this->MakeVisitorInsertArray($strPageId, $strMemberId, $strDate, $strTime);
    	$ar['comment'] = $strComment;
    	$ar['ip_id'] = $strIpId;
    	return $this->InsertArray($ar);
    }

    function UpdatePageComment($strId, $strComment, $strIpId)
    {
    	$ar = $this->MakeDateTimeArray();
    	$ar['comment'] = $strComment;
    	$ar['ip_id'] = $strIpId;
		return $this->UpdateById($ar, $strId);
	}
}

// ****************************** Blog Comment table *******************************************************
        
function SqlDeleteBlogCommentByMemberId($strMemberId)
{
    return SqlDeleteTableData(TABLE_PAGE_COMMENT, _SqlBuildWhere_member($strMemberId));
}

?>
