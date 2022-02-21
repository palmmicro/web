<?php
require_once('_stock.php');

function _getDebugIp($strLine)
{
	$arWord = explode(' ', $strLine);
   	return $arWord[1];
}

function _addDebugLine(&$arDebug, $strLine, $strLocalIp)
{
	$strIp = _getDebugIp($strLine);
	if ($strIp != $strLocalIp)
	{
		if (isset($arDebug[$strIp]))	$arDebug[$strIp] ++;
		else						    	$arDebug[$strIp] = 1;
	}
}

function _echoDebugParagraph($arDebug, $str, $sql)
{
	$str .= '：';
    foreach ($arDebug as $strIp => $iCount)
    {
    	if ($iCount > 2)
    	{
    		if ($sql->GetStatus($strIp) == IP_STATUS_NORMAL)		$str .= GetBreakElement().GetVisitorLink($strIp).' '.strval($iCount);
    	}
    }
    EchoParagraph($str);
}

function _echoStockDebug($sql)
{
    $arIp = array();
    $arUrl = array();
    $arCurl = array();
    $arMysql = array();
    
    $strLocalIp = UrlGetIp();
    if ($file = fopen(DebugGetFile(), 'r'))
    {
    	while (!feof($file))
    	{
    		$strLine = fgets($file);
    		if (strpos($strLine, 'timed out'))				_addDebugLine($arCurl, $strLine, $strLocalIp);
    		else if (strpos($strLine, 'MySQL server'))		_addDebugLine($arMysql, $strLine, $strLocalIp);
    		else if (strpos($strLine, 'Unknown URI'))		_addDebugLine($arUrl, $strLine, $strLocalIp);
    		else if (strpos($strLine, 'Unknown IP'))		_addDebugLine($arIp, $strLine, $strLocalIp);
        }
        fclose($file);
    }
    
    EchoParagraph('本机IP:'.GetVisitorLink($strLocalIp));
    _echoDebugParagraph($arCurl, 'curl错误', $sql);
    _echoDebugParagraph($arMysql, 'Mysql异常', $sql);
    _echoDebugParagraph($arUrl, '弱智爬虫', $sql);
    _echoDebugParagraph($arIp, 'IP异常', $sql);
}

function EchoAll()
{
	global $acct;
    
	_echoStockDebug($acct->GetIpSql());
    $acct->EchoLinks();
}

function GetMetaDescription()
{
  	$str = '格式化显示调试信息文件/debug/debug.txt. 用于更方便的查看和分析各个种类的调试信息, 区分不同种类的爬虫, 提高网站对真实访问用户的服务效率. ';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	return STOCK_DISP_DEBUG;
}

	$acct = new StockAccount(false, true);
?>
