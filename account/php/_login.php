<?php
require_once('_account.php');
require_once('php/_editemailform.php');
require_once('/php/ui/table.php');

function EchoAll($bChinese = true)
{
    $str = $bChinese ? '欢迎回来! 在过去12个月中没有登录过的账户会被自动清除. 你可以<a href="registercn.php">注册</a>新帐号. 忘记密码了? 点击<a href="remindercn.php">这里</a>.' 
                       : 'Welcome back! Account not login during the past 12 months is automatically removed. You can <a href="register.php">register</a> here. Forgot password? Click <a href="reminder.php">here</a>.';
   	EchoParagraph($str);
    EditEmailForm(EditEmailGetSubmit($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
	$str = EditEmailGetSubmit($bChinese);
    if ($bChinese)
    {
    	$str = "本中文页面文件跟/account/php/_login.php和/account/php/_editemailform.php一起配合完成{$str}的功能. 在过去12个月中没有登录过的账户会被自动清除.";
    }
    else
    {
    	$str = "This English web page works together with php/_login.php and php/_editemailform.php to $str.";
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
