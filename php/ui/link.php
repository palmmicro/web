<?php

function EchoLink($strHttp)
{
    $str = GetHttpLink($strHttp);
    echo $str;
}

function EchoSinaQuotesLink($strSinaSymbols)
{
	EchoLink(GetSinaQuotesUrl($strSinaSymbols));
}

function EchoFileLink($strPathName)
{
    $str = GetFileLink($strPathName);
    echo $str;
}

function EchoSinaDebugLink($strSina)
{
	EchoFileLink('/debug/sina/'.$strSina.'.txt');
}

function EchoMyStockLink($strSymbol, $bChinese = true)
{
    $str = GetMyStockLink($strSymbol, $bChinese);
    echo $str;
}

function EchoPhpFileLink($strPathTitle)
{
//    $strTxtPathName = str_replace('.', '_', $strPathName).'.txt';
    $strPathName = $strPathTitle.'.php';
    $strTxtPathName = $strPathTitle.'.txt';
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
