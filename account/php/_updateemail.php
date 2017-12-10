<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getEmailUpdateSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_UPDATE_CN;
    }
    else
    {
        $str = EDIT_EMAIL_UPDATE;
    }
    return $str;
}

function EchoEmailUpdateTitle($bChinese)
{
    $str = _getEmailUpdateSubmit($bChinese);
    echo $str;
}

function EchoEmailUpdate($bChinese)
{
    $strSubmit = _getEmailUpdateSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctAuth();
    
?>
