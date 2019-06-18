<?php

function EchoInternalLink($strPath, $strDisplay)
{
	echo GetInternalLink($strPath, $strDisplay);
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

function GetPhpFileLink($strPathTitle)
{
    $strPhp = $strPathTitle.'.php';
    $strTxt = $strPathTitle.'.txt';
    
    $bCopyFile = true;
    if (file_exists($strTxt))
    {
    	clearstatcache(true, $strTxt);
    	if (filemtime($strTxt) > filemtime($strPhp))		$bCopyFile = false;
	}
	
	if ($bCopyFile)
	{
		$str = file_get_contents($strPhp);
		file_put_contents($strTxt, DEBUG_UTF8_BOM.$str);
	}
    return GetExternalLink($strTxt, $strPhp);
}

function EchoPhpFileLink($strPathTitle)
{
	echo GetPhpFileLink($strPathTitle);
}

function EchoXueqieId($strId, $strDisplay)
{
    $str = GetXueqiuIdLink($strId, $strDisplay);
    echo $str;
}


?>
