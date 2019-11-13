<?php

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

function EchoXueqieId($strId, $strDisplay)
{
    $str = GetXueqiuIdLink($strId, $strDisplay);
    echo $str;
}

function EchoLinearRegressionLink($bChinese = true)
{
	echo GetLinearRegressionLink($bChinese);
}

function EchoBenfordsLawLink($bChinese = true)
{
	echo GetBenfordsLawLink($bChinese);
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

?>
