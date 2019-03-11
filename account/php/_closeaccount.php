<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function _getCloseAccountSubmit($bChinese)
{
    return $bChinese ? EDIT_EMAIL_CLOSE_CN : EDIT_EMAIL_CLOSE;
}

function EchoAll($bChinese = true)
{
    $str = $bChinese ? '关闭帐号后, 所有跟此帐号相关的数据都会被删除, 并且不可恢复.' : 'After account is closed, all related data is deleted and can not be recovered.';
   	EchoParagraph($str);
    EditEmailForm(_getCloseAccountSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = _getCloseAccountSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_closeaccount.php和/account/php/_editemailform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_closeaccount.php and php/_editemailform.php to $str.";
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = _getCloseAccountSubmit($bChinese);
    echo $str;
}

    AcctAuth();
    
?>
