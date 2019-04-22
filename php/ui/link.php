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

function EchoMyStockLink($strSymbol)
{
    $str = GetMyStockLink($strSymbol);
    echo $str;
}

function EchoExternalLink($strHttp, $strDisplay)
{
    $str = GetExternalLink($strHttp, $strDisplay);
    echo $str;
}

function EchoPhpFileLink($strPathTitle)
{
//    $strTxtPathName = str_replace('.', '_', $strPathName).'.txt';
    $strPathName = $strPathTitle.'.php';
    $strTxtPathName = $strPathTitle.'.txt';
    $str = file_get_contents($strPathName);
    file_put_contents($strTxtPathName, DEBUG_UTF8_BOM.$str);
    EchoExternalLink($strTxtPathName, $strPathName);
}

function EchoXueqieId($strId, $strDisplay)
{
    $str = GetXueqiuIdLink($strId, $strDisplay);
    echo $str;
}


?>
