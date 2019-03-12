<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function EchoAll($bChinese = true)
{
    $str = $bChinese ? '新的密码通过电子邮件发送.' : 'New password will be sent by email.';
   	EchoParagraph($str);
    EditEmailForm(EditEmailGetSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = EditEmailGetSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_reminder.php和/account/php/_editemailform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_reminder.php and php/_editemailform.php to $str.";
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    $str = EditEmailGetSubmit($bChinese);
    echo $str;
}

    AcctNoAuth();
    
?>
