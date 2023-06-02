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
	echo GetFileLink(DebugGetSinaFileName($strSina));
}

function EchoMyStockLink($strSymbol, $strDisplay = false)
{
	echo GetMyStockLink($strSymbol, $strDisplay);
}

function EchoXueqiuId($strId, $strDisplay)
{
    echo GetXueqiuIdLink($strId, $strDisplay);
}

function EchoBenfordsLawLink($bChinese = true)
{
	echo GetBenfordsLawLink($bChinese);
}

function EchoChiSquaredTestLink($bChinese = true)
{
	echo GetChiSquaredTestLink($bChinese);
}

function EchoDiceCaptchaLink($bChinese = true)
{
	echo GetDiceCaptchaLink($bChinese);
}

function EchoPrimeNumberLink($bChinese = true)
{
	echo GetPrimeNumberLink($bChinese);
}

function EchoCommonPhraseLink($bChinese = true)
{
	echo GetCommonPhraseLink($bChinese);
}

function EchoAutoTractorLink()
{
	echo GetAutoTractorLink();
}

?>
