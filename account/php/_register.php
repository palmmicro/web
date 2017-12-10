<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getEmailRegisterSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_REGISTER_CN;
    }
    else
    {
        $str = EDIT_EMAIL_REGISTER;
    }
    return $str;
}

function EchoEmailRegisterTitle($bChinese)
{
    $str = _getEmailRegisterSubmit($bChinese);
    echo $str;
}

function EchoEmailRegister($bChinese)
{
    $strSubmit = _getEmailRegisterSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctNoAuth();
    
?>
