<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getEmailLoginSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_LOGIN_CN;
    }
    else
    {
        $str = EDIT_EMAIL_LOGIN;
    }
    return $str;
}

function EchoEmailLoginTitle($bChinese = true)
{
    $str = _getEmailLoginSubmit($bChinese);
    echo $str;
}

function EchoEmailLogin($bChinese = true)
{
    $strSubmit = _getEmailLoginSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctNoAuth();
    
?>
