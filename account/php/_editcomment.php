<?php
require_once('_account.php');
require_once('php/_editcommentform.php');
require_once('/php/ui/plaintext.php');

function _getEditCommentSubmit($bChinese)
{
    return $bChinese ? BLOG_COMMENT_EDIT_CN : BLOG_COMMENT_EDIT;
}

function EchoAll($bChinese = true)
{
    EditCommentForm(_getEditCommentSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = _getEditCommentSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_submitcomment.php和/account/php/_editcommentform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_submitcomment.php and php/_editcommentform.php to $str.";
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = _getEditCommentSubmit($bChinese);
    echo $str;
}

   	$acct = new AcctStart();
	$acct->Auth();
?>

