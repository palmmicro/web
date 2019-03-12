<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function EchoAll($bChinese = true)
{
    $str = $bChinese ? '关闭帐号后所有跟此帐号相关的数据都会被删除, 并且不可恢复.' : 'After account is closed, all related data is deleted and can not be recovered.';
   	EchoParagraph($str);
    EditEmailForm(EditEmailGetSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = EditEmailGetSubmit($bChinese);
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
    $str = EditEmailGetSubmit($bChinese);
    echo $str;
}

    AcctAuth();
    
?>
