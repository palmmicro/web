<?php
require_once('_stock.php');

function _getDebugIp($strLine)
{
	$arWord = explode(' ', $strLine);
   	return $arWord[1];
}

function _addDebugLine(&$arDebug, $strLine)
{
	$strIp = _getDebugIp($strLine);
    if (isset($arDebug[$strIp]))
    {
    	$arDebug[$strIp] ++;
    }
    else
    {
    	$arDebug[$strIp] = 1;
    }
}

function _echoDebugParagraph($arDebug, $str)
{
	$str .= ':';
    foreach ($arDebug as $strIp => $iCount)
    {
    	if ($iCount > 2)
    	{
    		$str .= '<br />'.GetVisitorLink($strIp).' '.strval($iCount);
    	}
    }
    EchoParagraph($str);
}

function _echoAdminDebug()
{
    $arIp = array();
    $arUrl = array();
    $arCurl = array();
    $arMysql = array();
    
    if ($file = fopen(DebugGetFile(), 'r'))
    {
    	while (!feof($file))
    	{
    		$strLine = fgets($file);
    		if (strpos($strLine, 'timed out'))
    		{
    			_addDebugLine($arCurl, $strLine);
        	}
    		else if (strpos($strLine, 'MySQL server on'))
    		{
    			_addDebugLine($arMysql, $strLine);
        	}
    		else if (strpos($strLine, 'Unknown URI'))
    		{
    			_addDebugLine($arUrl, $strLine);
        	}
    		else if (strpos($strLine, 'Unknown IP'))
    		{
    			_addDebugLine($arIp, $strLine);
        	}
        }
        fclose($file);
    }

    _echoDebugParagraph($arCurl, 'curl错误');
    _echoDebugParagraph($arMysql, 'Mysql异常');
    _echoDebugParagraph($arUrl, '弱智爬虫');
    _echoDebugParagraph($arIp, 'IP异常');
}

function EchoAll()
{
	global $acct;
    
	_echoAdminDebug();
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
  	$str = '格式化显示调试信息文件/debug/debug.txt. 用于更方便的查看和分析各个种类的调试信息, 区分不同种类的爬虫, 提高网站对真实访问用户的服务效率. ';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo '调试信息';
}

	$acct = new StockAccount();
	$acct->AuthAdmin();
?>
