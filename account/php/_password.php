<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getEmailPasswordSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_PASSWORD_CN;
    }
    else
    {
        $str = EDIT_EMAIL_PASSWORD;
    }
    return $str;
}

function EchoEmailPasswordTitle($bChinese = true)
{
    $str = _getEmailPasswordSubmit($bChinese);
    echo $str;
}

function EchoEmailPassword($bChinese = true)
{
    $strSubmit = _getEmailPasswordSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctAuth();
    
?>
