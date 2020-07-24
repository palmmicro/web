<?php

define('MAX_COMMENT_DISPLAY', 5);

function _getSingleCommentTime($record, $bChinese)
{
    if ($record['created'] == $record['modified'])
    {
        if ($bChinese)    $str = '发表于'.$record['created'];
        else                $str = 'posted on '.$record['created'];
    }
	else
	{
	    if ($bChinese)    $str = '修改于'.$record['modified'];
	    else                $str = ' modified on '.$record['modified'];
	}
	return $str;
}

function GetSingleCommentDescription($record, $strWhere, $bChinese)
{
    $strAuthor = GetMemberLink($record['member_id'], $bChinese);
    $strIp = GetIpLink($record['ip'], $bChinese);
    $strTime = _getSingleCommentTime($record, $bChinese);
    
	$sql = new PageSql();
	$strUri = $sql->GetKey($record['blog_id']);
	
    $strTimeLink = "<a href=\"$strUri#{$record['id']}\">$strTime</a>";
    if (strpos($strWhere, 'blog_id') !== false)
    {
        $strTimeLink = "<b><a name=\"{$record['id']}\">$strTime</a></b>";
    }
    else if (strpos($strWhere, 'member_id') !== false)
    {
        $strAuthor = '';
    }
    else if (strpos($strWhere, 'ip') !== false)
    {
        $strIp = '';
    }
    
    return "$strAuthor $strTimeLink $strIp";
}

function _echoSingleCommentParagraph($record, $strMemberId, $bReadOnly, $bAdmin, $strWhere, $bChinese)
{
	$strEdit = '';
	$strDelete = '';
    if ($bReadOnly == false)
    {
        if ($record['member_id'] == $strMemberId)
        {	// I posted the comment
            $strEdit = GetEditLink('/account/editcomment', $record['id'], $bChinese);
        }

        // <a href="delete.page" onclick="return confirm('Are you sure you want to delete?')">Delete</a> 
        if ($bAdmin || $record['member_id'] == $strMemberId)
        {
            $strDelete = GetDeleteLink('/account/php/_submitcomment.php?delete='.$record['id'], '评论', 'comment', $bChinese);
        }
    }

    $strDescription = GetSingleCommentDescription($record, $strWhere, $bChinese);
	$strComment = nl2br($record['comment']);
	
	echo <<<END
	<p>$strDescription $strDelete $strEdit 
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="comment{$record['id']}">
        <tr>
            <td class=c1 width=640 align=center>$strComment</td>
        </tr>
        </TABLE>
	</p>
END;
}

function EchoCommentParagraphs($strMemberId, $bReadOnly, $bAdmin, $strWhere, $iStart, $iNum, $bChinese)
{
	if ($result = SqlGetBlogComment($strWhere, $iStart, $iNum)) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			_echoSingleCommentParagraph($record, $strMemberId, $bReadOnly, $bAdmin, $strWhere, $bChinese);
		}
		@mysql_free_result($result);
	}
}

function EchoCommentLinkParagraph($str, $strQuery, $bChinese)
{
    $str = "<font color=green>$str</font>";
    $str .= ' '.GetAllCommentLink($strQuery, $bChinese);
    EchoParagraph($str);
}

?>
