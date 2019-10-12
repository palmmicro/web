<?php

function EchoInternalLink($strPath, $strDisplay)
{
	echo GetInternalLink($strPath, $strDisplay);
}

function EchoNameLink($strName, $strDisplay)
{
	echo GetNameLink($strName, $strDisplay);
}

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

function EchoXueqieId($strId, $strDisplay)
{
    $str = GetXueqiuIdLink($strId, $strDisplay);
    echo $str;
}

?>
