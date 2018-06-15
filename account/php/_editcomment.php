<?php
require_once('_account.php');
require_once('php/_editcommentform.php');

function _getEditCommentSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = BLOG_COMMENT_EDIT_CN;
    }
    else
    {
        $str = BLOG_COMMENT_EDIT;
    }
    return $str;
}

function EchoEditCommentTitle($bChinese = true)
{
    $str = _getEditCommentSubmit($bChinese);
    echo $str;
}

function EchoEditComment($bChinese = true)
{
    $strSubmit = _getEditCommentSubmit($bChinese);
    EditCommentForm($strSubmit);
}

    AcctAuth();
    
?>

