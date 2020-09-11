<?php
require_once('_commonupdatestock.php');

/*
<a href="http://stock.finance.sina.com.cn/usstock/quotes/FXB.html" rel="suggest" title="FXB,Invesco CurrencyShares British Pound Sterling Trust,CurrencyShares追踪英镑币值ETF">英镑ETF(FXB)</a>
<a href="http://stock.finance.sina.com.cn/usstock/quotes/FXE.html" rel="suggest" title="FXE,Invesco CurrencyShares Euro Trust,CurrencyShares追踪欧元币值ETF">欧元ETF(FXE)</a>
<a href="http://stock.finance.sina.com.cn/usstock/quotes/YINN.html" rel="suggest" title="YINN,Direxion Daily FTSE China Bull 3X Shares,三倍做多A股新华50指数ETF">三倍做多(YINN)</a>
*/

function _updateUsStock()
{
    $strUrl = GetSinaUsStockListUrl();
    $str = url_get_contents($strUrl);
    if ($str == false)	return;

    $str = GbToUtf8($str);

    $strBoundary = RegExpBoundary();
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('title="', '[^"]*', '">');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateUsStock');
    $iCount = 0;
	$sql = GetStockSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode(',', $arItem[1]);
   		$strSymbol = reset($ar);
   		$strName = end($ar);
   		if ($sql->WriteSymbol($strSymbol, $strName))
   		{
   			DebugString($strSymbol.' '.$strName);
   			$iCount ++;
   		}
   	}
    DebugVal($iCount, 'US stock updated');
}
	
   	$acct = new Account();
	$acct->AdminCommand('_updateUsStock');
?>
