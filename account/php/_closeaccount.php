<?php
require_once('_account.php');
require_once('php/_editemailform.php');

function _getCloseAccountSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = EDIT_EMAIL_CLOSE_CN;
    }
    else
    {
        $str = EDIT_EMAIL_CLOSE;
    }
    return $str;
}

function EchoCloseAccountTitle($bChinese)
{
    $str = _getCloseAccountSubmit($bChinese);
    echo $str;
}

function EchoCloseAccount($bChinese)
{
    $strSubmit = _getCloseAccountSubmit($bChinese);
    EditEmailForm($strSubmit);
}

    AcctAuth();
    
?>
