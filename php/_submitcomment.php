<?php
require_once('account.php');
require_once('_editcommentform.php');

class _SubmitCommentAccount extends EditCommentAccount
{
	function _SubmitCommentAccount() 
    {
        parent::EditCommentAccount();
    }

    function _canModifyComment($strId, $comment_sql)
    {
    	if ($record = $comment_sql->GetRecordById($strId))
    	{
    		if ($this->CanModifyComment($record))	return $record;
    	}
    	return false;
    }

	function _onDelete($strId, $strMemberId)
	{
		$comment_sql = $this->GetCommentSql();
		if ($this->_canModifyComment($strId, $comment_sql))
		{
			if ($comment_sql->DeleteById($strId))
	    	{
	    		SqlChangeActivity($strMemberId, -1);
	    	}
	    }
	}

	function _emailBlogComment($comment_sql, $strId, $strBlogId, $strSubject, $strComment)
	{
		// build email contents
		$str = SqlGetEmailById($strId);
		$str .= " $strSubject:<br />$strComment<br />";
		$str .= $this->GetCommentPageLink($strBlogId);

		// build mailing list
		$arEmails = array(ADMIN_EMAIL);								// Array to store emails addresses to send to
		if ($result = $comment_sql->GetDataByDst($strBlogId)) 
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
					$arEmails[] = $strNewEmail;						// send to previous comments writer
				}
			}
			@mysql_free_result($result);
		}

		foreach($arEmails as $strEmail) 
		{
			if (EmailHtml($strEmail, $strSubject, $str) == false)
			{
				DebugString('mail failed in blog comment');
				break;
			}
		}	
	}

	function _onEdit($strId, $strMemberId, $strComment)
	{
		if ($strComment != '')
		{
			$comment_sql = $this->GetCommentSql();
			if ($record = $this->_canModifyComment($strId, $comment_sql))
			{
				if ($comment_sql->UpdatePageComment($strId, $strComment))
				{
					$this->_emailBlogComment($comment_sql, $strMemberId, $record['page_id'], $_POST['submit'], $_POST['comment']);
				}
			}
		}
		else
		{	// delete when empty
			$this->_onDelete($strId, $strMemberId);
		}
	}

	function _onNew($strMemberId, $strComment)
	{
		if ($strComment != '')
		{
			if ($strBlogId = $this->GetPageId(SwitchGetSess()))
			{
				$comment_sql = $this->GetCommentSql();
				if ($comment_sql->InsertPageComment($strBlogId, $strMemberId, $strComment))
				{
					SqlChangeActivity($strMemberId, 1);
					$this->_emailBlogComment($comment_sql, $strMemberId, $strBlogId, $_POST['submit'], $_POST['comment']);
				}
			}
		}
	}
	
    public function Process($strLoginId)
    {
		if ($strId = UrlGetQueryValue('delete'))
		{
			$this->_onDelete($strId, $strLoginId);
		}
		else if (isset($_POST['submit']))
		{
			$strComment = SqlCleanString($_POST['comment']);
			switch ($_POST['submit'])
			{
			case BLOG_COMMENT_NEW:
			case BLOG_COMMENT_NEW_CN:
				$this->_onNew($strLoginId, $strComment);
				break;

			case BLOG_COMMENT_EDIT:
			case BLOG_COMMENT_EDIT_CN:
				if ($strId = $this->GetQuery())
				{
					$this->_onEdit($strId, $strLoginId, $strComment);
				}
				break;
			}
			unset($_POST['submit']);
		}
    }
}

   	$acct = new _SubmitCommentAccount();
   	$acct->Run();

?>
