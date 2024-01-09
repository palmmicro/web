<?php
require_once('ui/commentparagraph.php');

define('BLOG_COMMENT_NEW', 'Post Comment');
define('BLOG_COMMENT_NEW_CN', '发表评论');

define('BLOG_COMMENT_EDIT', 'Edit Comment');
define('BLOG_COMMENT_EDIT_CN', '修改评论');

class EditCommentAccount extends CommentAccount
{
	public function __construct() 
    {
        parent::__construct('edit', array('editcomment'));
    }

    function _getEditComment()
    {
    	if ($strId = $this->GetQuery())
    	{
    		$sql = $this->GetCommentSql();
    		if ($record = $sql->GetRecordById($strId))
    		{
    			if ($record['member_id'] == $this->GetLoginId()) // check comment poster
    			{
    				return $record['comment'];
    			}
    		}
    	}
    	return ''; 
    }

    function EditCommentForm($strSubmit)
    {
    	$arTitle = array(BLOG_COMMENT_NEW => 'Any comment?', 
						   BLOG_COMMENT_NEW_CN => '有话想说?',
						   BLOG_COMMENT_EDIT => 'Clear to delete comment',
						   BLOG_COMMENT_EDIT_CN => '清空可以删除评论',
						   );
		
		$strPassQuery = UrlPassQuery();
		$strComment = $this->_getEditComment();
		$str = GetRemarkElement($arTitle[$strSubmit]);
    
		echo <<< END
	<form id="commentForm" name="commentForm" method="post" action="/php/_submitcomment.php{$strPassQuery}">
        <div>
		<p>$str
	    <br /><textarea name="comment" rows="16" cols="75" id="comment">$strComment</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
    }
}

?>
