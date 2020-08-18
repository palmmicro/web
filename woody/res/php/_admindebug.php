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
    	if ($iCount > 1)
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
    if ($file = fopen(DebugGetFile(), 'r'))
    {
    	while (!feof($file))
    	{
    		$strLine = fgets($file);
    		if (strpos($strLine, 'Resolving timed out after'))
    		{
    			_addDebugLine($arIp, $strLine);
        	}
    		else if (strpos($strLine, 'Unknown URI'))
    		{
    			_addDebugLine($arUrl, $strLine);
        	}
        }
        fclose($file);
    }

    _echoDebugParagraph($arIp, 'curl错误信息');
    _echoDebugParagraph($arUrl, '弱智爬虫');
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
