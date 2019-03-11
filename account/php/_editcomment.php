<?php
require_once('_account.php');
require_once('php/_editcommentform.php');

function _getEditCommentSubmit($bChinese)
{
    return $bChinese ? BLOG_COMMENT_EDIT_CN : BLOG_COMMENT_EDIT;
}

function EchoEditCommentTitle($bChinese = true)
{
    $str = _getEditCommentSubmit($bChinese);
    echo $str;
}

function EchoEditComment($bChinese = true)
{
    EditCommentForm(_getEditCommentSubmit($bChinese));
}

    AcctAuth();
    
?>

