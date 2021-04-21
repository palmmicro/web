<?php

function EchoExternalLink($strHttp, $strDisplay)
{
    echo GetExternalLink($strHttp, $strDisplay);
}

function EchoInternalLink($strPath, $strDisplay)
{
	echo GetInternalLink($strPath, $strDisplay);
}

function EchoNameTag($strName, $strDisplay)
{
	echo GetNameTag($strName, $strDisplay);
}

function EchoNameLink($strName, $strDisplay, $strPage = '')
{
	echo GetNameLink($strName, $strDisplay, $strPage);
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

function EchoMyStockLink($strSymbol, $strDisplay = false)
{
	echo GetMyStockLink($strSymbol, $strDisplay);
}

function EchoXueqieId($strId, $strDisplay)
{
    echo GetXueqiuIdLink($strId, $strDisplay);
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

function EchoWoodyPortfolioLink()
{
	echo GetMyPortfolioLink('email=woody@palmmicro.com');
}

?>
