<?php
require_once('/php/account.php');
require_once('/php/externalurl.php');
require_once('/php/regexp.php');
require_once('/php/gb2312.php');
require_once('/php/stock/stocksymbol.php');
require_once('/php/sql/sqlstocksymbol.php');

/*
<li class="b"><div><a href="http://fund.eastmoney.com/000001.html">（000001）华夏成长</a> | <a href="http://jijinba.eastmoney.com/topic,000001.html">基金吧</a> | <a href="http://fundf10.eastmoney.com/000001.html">档案</a></div></li>
<li class="b"><div><a href="http://fund.eastmoney.com/000003.html">（000003）中海可转债债券A</a> | <a href="http://jijinba.eastmoney.com/topic,000003.html">基金吧</a> | <a href="http://fundf10.eastmoney.com/000003.html">档案</a></div></li>
<li class="b"><div><a href="http://fund.eastmoney.com/000004.html">（000004）中海可转债债券C</a> | <a href="http://jijinba.eastmoney.com/topic,000004.html">基金吧</a> | <a href="http://fundf10.eastmoney.com/000004.html">档案</a></div></li>
<li><div><a href="http://fund.eastmoney.com/000005.html">（000005）嘉实增强信用定期债券</a> | <a href="http://jijinba.eastmoney.com/topic,000005.html">基金吧</a> | <a href="http://fundf10.eastmoney.com/000005.html">档案</a></div></li>
<li><div><a href="http://fund.eastmoney.com/000006.html">（000006）西部利得量化成长混合</a> | <a href="http://jijinba.eastmoney.com/topic,000006.html">基金吧</a> | <a href="http://fundf10.eastmoney.com/000006.html">档案</a></div></li>
*/

function _updateChinaFund()
{
    $strUrl = GetEastMoneyFundListUrl();
    $str = url_get_contents($strUrl);
    $str = FromGB2312ToUTF8($str);
//	DebugString($str);

    $strBoundary = RegExpBoundary();
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('html">（', '[^<]*', '</a>');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateChinaFund');
    $iCount = 0;
	$sql = new StockSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode('）', $arItem[1]);
   		if ($strSymbol = BuildChineseFundSymbol($ar[0]))
   		{
   			$strName = $ar[1];
   			if ($sql->Write($strSymbol, $strName))
   			{
   				DebugString($strSymbol.' '.$strName);
   				$iCount ++;
   			}
   		}
   	}
    DebugVal($iCount, 'updated');
}
	
	AcctAdminCommand('_updateChinaFund');

?>
