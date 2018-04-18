<?php

function EchoLink($strHttp)
{
    $str = GetHttpLink($strHttp);
    echo $str;
}

function EchoFileLink($strPathName)
{
    $str = GetFileLink($strPathName);
    echo $str;
}

function EchoMyStockLink($strSymbol)
{
    $str = GetMyStockLink($strSymbol, true);
    echo $str;
}

function EchoPhpFileLink($strPathName)
{
    $strTxtPathName = str_replace('.', '_', $strPathName).'.txt';
    $str = file_get_contents($strPathName);
    file_put_contents($strTxtPathName, DEBUG_UTF8_BOM.$str);
    $str = GetExternalLink($strTxtPathName, $strPathName);
    echo $str;
}

function EchoXueqieId($strId, $strDisplay)
{
    $str = GetExternalLink('https://xueqiu.com/u/'.$strId, $strDisplay);
    echo $str;
}


?>
