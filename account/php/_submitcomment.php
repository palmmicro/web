<?php
require_once('/php/account.php');
require_once('_editcommentform.php');

function _onDelete($strId, $strMemberId)
{
    if (SqlDeleteTableDataById('blogcomment', $strId))
    {
        SqlChangeActivity($strMemberId, -1);
    }
}

function _onEdit($strId, $strMemberId, $strComment)
{
    if ($strComment != '')
    {
        if (SqlEditBlogComment($strId, $strComment))
		{
		    $comment = SqlGetBlogCommentById($strId);
		    EmailBlogComment($strMemberId, $comment['blog_id'], $_POST['submit'], $_POST['comment']);
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
			EmailBlogComment($strMemberId, $strBlogId, $_POST['submit'], $_POST['comment']);
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
		$strSubmit = $_POST['submit'];
		$strComment = FormatCleanString($_POST['comment']);
		if ($strSubmit == BLOG_COMMENT_NEW || $strSubmit == BLOG_COMMENT_NEW_CN)
		{	// post new comment
		    _onNew($strMemberId, $strComment);
		}
		else if ($strSubmit == BLOG_COMMENT_EDIT || $strSubmit == BLOG_COMMENT_EDIT_CN)
		{	// edit comment
			if ($strId = UrlGetQueryValue('edit'))
			{
			    _onEdit($strId, $strMemberId, $strComment);
			}
		}
		unset($_POST['submit']);
	}

	SwitchToSess();
?>
