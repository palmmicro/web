<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getPasswordReminderSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_REMINDER_CN;
    }
    else
    {
        $str = EDIT_EMAIL_REMINDER;
    }
    return $str;
}

function EchoPasswordReminderTitle($bChinese)
{
    $str = _getPasswordReminderSubmit($bChinese);
    echo $str;
}

function EchoPasswordReminder($bChinese)
{
    $strSubmit = _getPasswordReminderSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctNoAuth();
    
?>
