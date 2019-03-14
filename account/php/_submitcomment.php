<?php
require_once('/php/account.php');
require_once('_editcommentform.php');

function _emailBlogComment($strId, $strBlogId, $strSubject, $strComment)
{
	$strBlogUri = SqlGetUriByBlogId($strBlogId);
	
	// build email contents
	$str = SqlGetEmailById($strId);
	$str .= " $strSubject:<br />$strComment<br />";
	$str .= GetBlogLink($strBlogId);

	// build mailing list
	$arEmails = array();				                                                    // Array to store emails addresses to send to
	$arEmails[] = AcctGetEmailFromBlogUri($strBlogUri);                                 // always send to blog writer
//	$arEmails[] = UrlGetEmail('support');					                                // always send to support@domain.com
	if ($result = SqlGetBlogCommentByBlogId($strBlogId)) 
	{
		while ($comment = mysql_fetch_assoc($result)) 
		{
			$strNewEmail = SqlGetEmailById($comment['member_id']);
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
	
    $comment = SqlGetBlogCommentById($strId);
    if ($comment['member_id'] == $strMemberId)                          return true;    // I posted the comment
    if (SqlGetMemberIdByBlogId($comment['blog_id']) == $strMemberId)   return true;     // I posted the blog
    
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
    	        $comment = SqlGetBlogCommentById($strId);
    	        _emailBlogComment($strMemberId, $comment['blog_id'], $_POST['submit'], $_POST['comment']);
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
    $strBlogId = SqlGetBlogIdByUri($_SESSION['userurl']);
	if ($strBlogId && $strComment != '')
    {
	    if (SqlInsertBlogComment($strMemberId, $strBlogId, $strComment))
		{
			SqlChangeActivity($strMemberId, 1);
			_emailBlogComment($strMemberId, $strBlogId, $_POST['submit'], $_POST['comment']);
		}
	}
}

    $strMemberId = AcctAuth();
	if ($strId = UrlGetQueryValue('delete'))
	{
	    _onDelete($strId, $strMemberId);
	}
	else if (isset($_POST['submit']))
	{
		$strComment = UrlCleanString($_POST['comment']);
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

	SwitchToSess();
?>
