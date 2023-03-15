<?php

function EchoExternalLink($strHttp, $strDisplay = false)
{
    echo GetExternalLink($strHttp, $strDisplay);
}

function EchoInternalLink($strPath, $strDisplay = false)
{
	echo GetInternalLink($strPath, $strDisplay);
}

function EchoNameTag($strName, $strDisplay = false)
{
	echo GetNameTag($strName, $strDisplay);
}

function EchoNameLink($strName, $strDisplay = false, $strLink = '')
{
	echo GetNameLink($strName, $strDisplay, $strLink);
}

function EchoSinaQuotesLink($strSinaSymbols)
{
	echo GetSinaQuotesLink($strSinaSymbols);
}

function EchoFileLink($strPathName)
{
    $str = GetFileLink($strPathName);
    echo $str;
}

function EchoSinaDebugLink($strSina)
{
	EchoFileLink(DebugGetSinaFileName($strSina));
}

function EchoMyStockLink($strSymbol, $strDisplay = false)
{
	echo GetMyStockLink($strSymbol, $strDisplay);
}

function EchoXueqieId($strId, $strDisplay)
{
    echo GetXueQiuIdLink($strId, $strDisplay);
}

function EchoLinearRegressionLink($bChinese = true)
{
	echo GetLinearRegressionLink($bChinese);
}

function EchoBenfordsLawLink($bChinese = true)
{
	echo GetBenfordsLawLink($bChinese);
}

function EchoChiSquaredTestLink($bChinese = true)
{
	echo GetChiSquaredTestLink($bChinese);
}

function EchoCramersRuleLink($bChinese = true)
{
	echo GetCramersRuleLink($bChinese);
}

function EchoDiceCaptchaLink($bChinese = true)
{
	echo GetDiceCaptchaLink($bChinese);
}

function EchoEditInputLink($bChinese = true)
{
	echo GetEditInputLink($bChinese);
}

function EchoPrimeNumberLink($bChinese = true)
{
	echo GetPrimeNumberLink($bChinese);
}

function EchoCommonPhraseLink($bChinese = true)
{
	echo GetCommonPhraseLink($bChinese);
}

function EchoIpAddressLink($bChinese = true)
{
	echo GetIpAddressLink($bChinese);
}

function EchoAutoTractorLink()
{
	echo GetAutoTractorLink();
}

?>
