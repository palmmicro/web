<?php

function EchoExternalLink($strHttp, $strDisplay = false)
{
    echo GetExternalLink($strHttp, $strDisplay);
}

function EchoNameTag($strName, $strDisplay = false)
{
	echo GetNameTag($strName, $strDisplay);
}

function EchoNameLink($strName, $strDisplay = false, $strLink = '')
{
	echo GetNameLink($strName, $strDisplay, $strLink);
}

function EchoSinaDataLink($strSinaSymbols)
{
	echo GetSinaDataLink($strSinaSymbols);
}

function EchoSinaDebugLink($strSina)
{
	echo GetSinaDebugLink($strSina);
}

function EchoMyStockLink($strSymbol, $strDisplay = false)
{
	echo GetMyStockLink($strSymbol, $strDisplay);
}

function EchoXueqiuId($strId, $strDisplay)
{
    echo GetXueqiuIdLink($strId, $strDisplay);
}

function EchoAutoTractorLink()
{
	echo GetAutoTractorLink();
}

?>
