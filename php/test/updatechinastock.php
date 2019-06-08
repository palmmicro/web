<?php
require_once('_commonupdatestock.php');

/*
<li><a target="_blank" href="http://quote.eastmoney.com/sh204001.html">GC001(204001)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sh501018.html">南方原油(501018)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sh580019.html">石化CWB1(580019)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sh600028.html">中国石化(600028)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sh900950.html">新城B股(900950)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sz000002.html">万科A(000002)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sz031005.html">国安GAC1(031005)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sz131810.html">R-001(131810)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sz200429.html">粤高速B(200429)</a></li>
<li><a target="_blank" href="http://quote.eastmoney.com/sz300033.html">同花顺(300033)</a></li>
*/

function _updateChinaStock()
{
    $strUrl = GetEastMoneyStockListUrl();
    $str = url_get_contents($strUrl);
    $str = FromGB2312ToUTF8($str);

    $strBoundary = RegExpBoundary();
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('html">', '[^<]*', '</a>');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateChinaStock');
    $iCount = 0;
	$sql = new StockSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode('(', $arItem[1]);
   		if ($strSymbol = BuildChineseStockSymbol(rtrim($ar[1], ')')))
   		{
   			$strName = $ar[0];
   			if ($sql->Write($strSymbol, $strName))
   			{
   				DebugString($strSymbol.' '.$strName);
   				$iCount ++;
   			}
		}
   	}
    DebugVal($iCount, 'updated');
}
	
	AcctAdminCommand('_updateChinaStock');

?>
