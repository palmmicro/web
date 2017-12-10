<?php

function EchoLink($strHttp)
{
    $str = DebugGetLink($strHttp);
    echo $str;
}

function EchoFileLink($strPathName)
{
    $str = DebugFileLink($strPathName);
    echo $str;
}

function EchoPhpFileLink($strPathName)
{
    $strTxtPathName = str_replace('.', '_', $strPathName).'.txt';
    $str = file_get_contents($strPathName);
    file_put_contents($strTxtPathName, DEBUG_UTF8_BOM.$str);
    $str = DebugGetExternalLink($strTxtPathName, $strPathName);
    echo $str;
}

?>
