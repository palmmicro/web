<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function EchoAll($bChinese = true)
{
    $str = $bChinese ? '我们通过登录电子邮件联系你, 务必确认能收到这个地址的电子邮件.' : 'Login email is used to contact you, make sure you can receive email from it.';
   	EchoParagraph($str);
    EditEmailForm(EditEmailGetSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = EditEmailGetSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_updateemail.php和/account/php/_editemailform.php一起配合完成{$str}的功能.";
    }
    else
    {
    	$str = "This English web page works together with php/_updateemail.php and php/_editemailform.php to $str.";
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
