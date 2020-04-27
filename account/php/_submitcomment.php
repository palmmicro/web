<?php
require_once('/php/account.php');
require_once('_editcommentform.php');

function _emailBlogComment($strId, $strBlogId, $strSubject, $strComment)
{
	// build email contents
	$str = SqlGetEmailById($strId);
	$str .= " $strSubject:<br />$strComment<br />";
	$str .= GetBlogLink($strBlogId);

	// build mailing list
	$arEmails = array();				                                                    // Array to store emails addresses to send to
	$arEmails[] = UrlGetEmail('support');					                                // always send to support@domain.com
	if ($result = SqlGetBlogCommentByBlogId($strBlogId)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			$strNewEmail = SqlGetEmailById($record['member_id']);
			$bFound = false;
			foreach($arEmails as $strEmail) 
			{
				if ($strNewEmail == $strEmail)
				{
					$bFound = true;
					break;
				}
			}		
			if ($bFound == false)
			{
				$arEmails[] = $strNewEmail;					// send to previous comments writer
			}
		}
		@mysql_free_result($result);
	}

	foreach($arEmails as $strEmail) 
	{
		EmailHtml($strEmail, $strSubject, $str);
	}	
}

function _canModifyComment($strId, $strMemberId)
{
	if (AcctIsAdmin())    return true;
	
    $record = SqlGetBlogCommentById($strId);
    if ($record['member_id'] == $strMemberId)	return true;    // I posted the comment
    
    return false;
}

function _onDelete($strId, $strMemberId)
{
	if (_canModifyComment($strId, $strMemberId))
	{
	    if (SqlDeleteTableDataById('blogcomment', $strId))
	    {
	        SqlChangeActivity($strMemberId, -1);
	    }
	}
}

function _onEdit($strId, $strMemberId, $strComment)
{
    if ($strComment != '')
    {
        if (_canModifyComment($strId, $strMemberId))
    	{
    	    if (SqlEditBlogComment($strId, $strComment))
    	    {
    	        $record = SqlGetBlogCommentById($strId);
    	        _emailBlogComment($strMemberId, $record['blog_id'], $_POST['submit'], $_POST['comment']);
    	    }
    	}
	}
	else
	{	// delete when empty
	    _onDelete($strId, $strMemberId);
	}
}

function _onNew($strMemberId, $strComment)
{
    $strUri = SwitchGetSess();
	$sql = new PageSql();
	if ($strBlogId = $sql->GetId($strUri))
	{
		if ($strComment != '')
		{
			if (SqlInsertBlogComment($strMemberId, $strBlogId, $strComment))
			{
				SqlChangeActivity($strMemberId, 1);
				_emailBlogComment($strMemberId, $strBlogId, $_POST['submit'], $_POST['comment']);
			}
		}
	}
}

   	$acct = new AcctStart();
	if ($strMemberId = $acct->GetLoginId())
	{
		if ($strId = UrlGetQueryValue('delete'))
		{
			_onDelete($strId, $strMemberId);
		}
		else if (isset($_POST['submit']))
		{
			$strComment = SqlCleanString($_POST['comment']);
			switch ($_POST['submit'])
			{
			case BLOG_COMMENT_NEW:
			case BLOG_COMMENT_NEW_CN:
				_onNew($strMemberId, $strComment);
				break;

			case BLOG_COMMENT_EDIT:
			case BLOG_COMMENT_EDIT_CN:
				if ($strId = UrlGetQueryValue('edit'))
				{
					_onEdit($strId, $strMemberId, $strComment);
				}
				break;
			}
			unset($_POST['submit']);
		}
	}

	$acct->Back();
?>
