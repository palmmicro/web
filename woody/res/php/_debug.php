<?php
require_once('_stock.php');

function _getDebugIp($strLine)
{
	$arWord = explode(' ', $strLine);
   	return $arWord[1];
}

function _addDebugLine(&$arDebug, $strLine, $strLocalIp, $bAuto = false)
{
	$strIp = _getDebugIp($strLine);
	if ($strIp != $strLocalIp)
	{
		if (isset($arDebug[$strIp]))	$arDebug[$strIp] ++;
		else						    	$arDebug[$strIp] = 1;
		
		if ($bAuto)
		{
			if (strpos($strLine, 'account/comment'))	
			{
				global $acct;
				$acct->SetMalicious($strIp);
			}
		}
	}
}

function _echoDebugParagraph($arDebug, $str)
{
	$str .= '：';
    foreach ($arDebug as $strIp => $iCount)
    {
    	if ($iCount > 2)		$str .= GetBreakElement().GetVisitorLink($strIp).' '.strval($iCount);
    }
    EchoParagraph($str);
}

function _echoStockDebug()
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
    		if (strpos($strLine, 'Connection timed out') || strpos($strLine, 'Empty reply from server'))												_addDebugLine($arCurl, $strLine, $strLocalIp);
    		else if (strpos($strLine, 'MySQL server') || strpos($strLine, 'SELECT * FROM'))															_addDebugLine($arMysql, $strLine, $strLocalIp, true);
    		else if (strpos($strLine, 'Unknown URI') || strpos($strLine, '分级A') || strpos($strLine, '分级B') || strpos($strLine, '退市'))	_addDebugLine($arUrl, $strLine, $strLocalIp);
    		else if (strpos($strLine, 'Unknown IP'))																									_addDebugLine($arIp, $strLine, $strLocalIp);
        }
        fclose($file);
    }
    
    EchoParagraph('本机IP:'.GetVisitorLink($strLocalIp));
    _echoDebugParagraph($arCurl, 'curl错误');
    _echoDebugParagraph($arMysql, 'Mysql异常');
    _echoDebugParagraph($arUrl, '弱智爬虫');
    _echoDebugParagraph($arIp, 'IP异常');
}

function _echoFileDebug()
{
	echo <<< END
	<form action="uploadfile.php" method="post" enctype="multipart/form-data">
        <div>
		<label for="file">Filename:</label>
		<input type="file" name="file" id="file" /> 
		<br />
		<input type="submit" name="submit" value="Submit" />
        </div>
	</form>
END;
}

function EchoAll()
{
	global $acct;
    
	_echoStockDebug();
	_echoFileDebug();
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
