<?php
require_once('/php/ui/htmlelement.php');

define ('BLOG_COMMENT_NEW', 'Post Comment');
define ('BLOG_COMMENT_NEW_CN', '发表评论');

define ('BLOG_COMMENT_EDIT', 'Edit Comment');
define ('BLOG_COMMENT_EDIT_CN', '修改评论');

function _getEditComment($strMemberId)
{
	if ($strId = UrlGetQueryValue('edit'))
	{
        if ($comment = SqlGetBlogCommentById($strId))
        {
            if ($comment['member_id'] == $strMemberId) // check comment poster
            {
                return $comment['comment'];
            }
	    }
	}
	return ''; 
}

function _getEditCommentTitle($strSubmit)
{
    $strTitle = '';
    if ($strSubmit == BLOG_COMMENT_NEW_CN)
    {
        $strTitle = '有话想说?';
    }
    else if ($strSubmit == BLOG_COMMENT_NEW)
    {
        $strTitle = 'Any comment?';
    }
    return $strTitle;
}

function EditCommentForm($strSubmit)
{
    $strMemberId = AcctIsLogin();
    $strPassQuery = UrlPassQuery();
    $strTitle = _getEditCommentTitle($strSubmit);
	$strComment = _getEditComment($strMemberId); 
    
	echo <<< END
	<form id="commentForm" name="commentForm" method="post" action="/account/php/_submitcomment.php$strPassQuery">
        <div>
		<p><font color=green>$strTitle</font>
	    <br /><textarea name="comment" rows="16" cols="75" id="comment">$strComment</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
}

?>
