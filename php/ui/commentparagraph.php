<?php

define('MAX_COMMENT_DISPLAY', 5);

function EchoCommentLinkParagraph($str, $strQuery, $bChinese)
{
    $str = "<font color=green>$str</font>";
    $str .= ' '.GetAllCommentLink($strQuery, $bChinese);
    EchoParagraph($str);
}

class CommentAccount extends TitleAccount
{
	var $comment_sql;
	
    function CommentAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::TitleAccount($strQueryItem, $arLoginTitle);
        $this->comment_sql = new PageCommentSql();
    }
    
    function GetPageIdQuery()
    {
    	return UrlGetQueryValue('page_id');
    }
    	
    function GetCommentSql()
    {
    	return $this->comment_sql;
    }

    function GetCommentPageLink($strPageId)
    {
    	if ($strPageUri = $this->GetPageUri($strPageId))
    	{
    		return GetInternalLink($strPageUri, UrlGetFileName($strPageUri));
    	}
    	return '';
    }
    
    function BuildWhereByMember($strMemberId)
    {
    	return $this->comment_sql->BuildWhereBySrc($strMemberId);
    }
    
    function BuildWhereByPage($strPageId)
    {
    	return $this->comment_sql->BuildWhereByDst($strPageId);
    }
    
    function BuildWhereByIp($strIp)
    {
    	return $this->comment_sql->BuildWhereByIp($strIp);
    }
    
	function CountComments($strWhere)
    {
		return $this->comment_sql->CountData($strWhere);
	}
	
	function CanModifyComment($record)
	{
		if ($record['member_id'] == $this->GetLoginId())
		{	// I posted the comment
			return true;
		}
		return false;
	}
	
    function GetCommentDescription($record, $strWhere, $bChinese)
    {
    	$strEdit = '';
   		if ($bCanModify = $this->CanModifyComment($record))
   		{
   			$strEdit = GetEditLink('/account/editcomment', $record['id'], $bChinese);
   		}

    	$strDelete = '';
   		if ($this->IsAdmin() || $bCanModify)
   		{	
   			$strDelete = GetDeleteLink('/account/php/_submitcomment.php?delete='.$record['id'], '评论', 'comment', $bChinese);
   		}

    	$strTime = $record['date'].' '.$record['time'];
    	$strAuthor = GetMemberLink($record['member_id'], $bChinese);

    	$strIp = GetIpLink(GetIp($record['ip_id']), $bChinese);
		$strUri = $this->GetPageUri($record['page_id']);
		$strTimeLink = "<a href=\"$strUri#{$record['id']}\">$strTime</a>";
		
		if (strpos($strWhere, 'page_id') !== false)
		{
			$strTimeLink = "<b><a name=\"{$record['id']}\">$strTime</a></b>";
		}
		else if (strpos($strWhere, 'member_id') !== false)
		{
			$strAuthor = '';
		}
		else if (strpos($strWhere, 'ip_id') !== false)
		{
			$strIp = '';
		}
    
		return "$strAuthor $strTimeLink $strIp $strDelete $strEdit";
	}

    function _echoSingleComment($record, $strWhere, $bChinese)
    {
    	$strDescription = $this->GetCommentDescription($record, $strWhere, $bChinese);
    	$strComment = nl2br($record['comment']);
	
    	echo <<<END
	<p>$strDescription 
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="comment{$record['id']}">
        <tr>
            <td class=c1 width=640 align=center>$strComment</td>
        </tr>
        </TABLE>
	</p>
END;
	}

	function EchoComments($strWhere, $iStart, $iNum, $bChinese)
    {
    	if ($result = $this->comment_sql->GetAll($strWhere, $iStart, $iNum)) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$this->_echoSingleComment($record, $strWhere, $bChinese);
    		}
    		@mysql_free_result($result);
    	}
    }
}

?>
