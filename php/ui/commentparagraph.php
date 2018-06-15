<?php

define('MAX_COMMENT_DISPLAY', 5);

function _getSingleCommentTime($comment, $bChinese)
{
    if ($comment['created'] == $comment['modified'])
    {
        if ($bChinese)    $str = '发表于'.$comment['created'];
        else                $str = 'posted on '.$comment['created'];
    }
	else
	{
	    if ($bChinese)    $str = '修改于'.$comment['modified'];
	    else                $str = ' modified on '.$comment['modified'];
	}
	return $str;
}

function GetSingleCommentDescription($comment, $strWhere, $bChinese)
{
    $strAuthor = GetMemberLink($comment['member_id'], $bChinese);
    $strIp = GetIpLink($comment['ip'], $bChinese);
    $strTime = _getSingleCommentTime($comment, $bChinese);
    $strUri = SqlGetUriByBlogId($comment['blog_id']);
    $strTimeLink = "<a href=\"$strUri#{$comment['id']}\">$strTime</a>";
    if (strstr($strWhere, 'blog_id'))
    {
        $strTimeLink = "<b><a name=\"{$comment['id']}\">$strTime</a></b>";
    }
    else if (strstr($strWhere, 'member_id'))
    {
        $strAuthor = '';
    }
    else if (strstr($strWhere, 'ip'))
    {
        $strIp = '';
    }
    
    return "$strAuthor $strTimeLink $strIp";
}

function _echoSingleCommentParagraph($comment, $strMemberId, $strWhere, $bChinese)
{
	$strEdit = '';
	$strDelete = '';
    if (AcctIsReadOnly($strMemberId) == false)
    {
        if ($comment['member_id'] == $strMemberId)
        {	// I posted the comment
            $strEdit = GetEditLink('/account/editcomment', $comment['id'], $bChinese);
        }

        // <a href="delete.page" onclick="return confirm('Are you sure you want to delete?')">Delete</a> 
        if (SqlGetMemberIdByBlogId($comment['blog_id']) == $strMemberId || $comment['member_id'] == $strMemberId)
        {	// I posted the blog or the comment
            $strDelete = GetDeleteLink('/account/php/_submitcomment.php?delete='.$comment['id'], '评论', 'comment', $bChinese);
        }
    }

    $strDescription = GetSingleCommentDescription($comment, $strWhere, $bChinese);
	$strComment = nl2br($comment['comment']);
	
	echo <<<END
	<p>$strDescription $strDelete $strEdit 
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="comment{$comment['id']}">
        <tr>
            <td class=c1 width=640 align=center>$strComment</td>
        </tr>
        </TABLE>
	</p>
END;
}

function EchoCommentParagraphs($strMemberId, $strWhere, $iStart, $iNum, $bChinese)
{
	if ($result = SqlGetBlogComment($strWhere, $iStart, $iNum)) 
	{
		while ($comment = mysql_fetch_assoc($result)) 
		{
			_echoSingleCommentParagraph($comment, $strMemberId, $strWhere, $bChinese);
		}
		@mysql_free_result($result);
	}
}

?>
