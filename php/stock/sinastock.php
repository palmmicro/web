<?php
// http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/601006.phtml
// http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/000001/type/S.phtml?year=2018&jidu=1
function SinaGetStockHistoryUrl($sym, $iYear = false, $iSeason = false)
{
	$str = 'http://money.finance.sina.com.cn/corp/go.php/vMS_MarketHistory/stockid/';
	if ($strDigit = $sym->IsIndexA())
	{
		$str .= $strDigit.'/type/S.phtml';
	}
	else if ($strDigit = $sym->IsSymbolA())
	{
		$str .= $strDigit.'.phtml';
	}
	
	if ($iYear)
	{
		$str .= '?year='.strval($iYear);
		if ($iSeason)
		{
			$str .= '&jidu='.strval($iSeason);
		}
	}
	return $str;
}

function SinaGetStockHistory($sym, $iYear = false, $iSeason = false)
{
    $strUrl = SinaGetStockHistoryUrl($sym, $iYear, $iSeason);
    DebugString($strUrl);
    return url_get_contents($strUrl); 
}

/*
			<td><div align="center">
					<a target='_blank' href='http://vip.stock.finance.sina.com.cn/quotes_service/view/vMS_tradehistory.php?symbol=sh000001&date=2018-05-29'>
			2018-05-29			</a>
						</div></td>
			<td><div align="center">3129.621</div></td>
			<td><div align="center">3143.208</div></td>
			<td><div align="center">3120.461</div></td>
			<td class="tdr"><div align="center">3112.153</div></td>
			<td class="tdr"><div align="center">13571780000</div></td>
			<td class="tdr"><div align="center">177826106449</div></td>
*/
function preg_match_sina_history($str)
{
    $strBoundary = RegExpBoundary();
    $strDate = RegExpDate();
    $strSpace = RegExpSpace();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis("date=$strDate'>$strSpace", $strDate, "$strSpace</a>$strSpace</div></td>");
    for ($i = 0; $i < 6; $i ++)
    {
        $strPattern .= RegExpParenthesis("$strSpace<td".RegExpSkip($strSpace.'class="tdr"').'><div align="center">', RegExpNumber(), '</div></td>');
//        $strPattern .= RegExpParenthesis($strSpace.'<td[^\d]*', '[^<]*', '</div></td>');
    }
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}
			
/*
<tr>
							<td>2017-04-19</td>
							<td>0</td>
							<td>0</td>
							<td>3.3</td>
														
							<td>预案</td>
							<td>--</td>
							<td>--</td>
							<td>--</td>
							<td><a target="_blank" href="/corp/view/vISSUE_ShareBonusDetail.php?stockid=000028&type=1&end_date=2017-04-19">查看</a></td>
						</tr>
											<tr>
							<td>2016-05-24</td>
							<td>0</td>
							<td>0</td>
							<td>3</td>
														
							<td>实施</td>
							<td>2016-05-30</td>
							<td>2016-05-27</td>
							<td>--</td>
							<td><a target="_blank" href="/corp/view/vISSUE_ShareBonusDetail.php?stockid=000028&type=1&end_date=2016-05-24">查看</a></td>
						</tr>*/
function SinaGetStockDividendA($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $strUrl = GetStockDividendUrl($sym);
    if ($str = url_get_contents($strUrl))
    {
    	$str = FromGB2312ToUTF8($str);

    	$strBoundary = RegExpBoundary();
    	$strSpace = RegExpSpace();
    
    	$strPattern = $strBoundary;
    	$strPattern .= RegExpParenthesis('<tr>'.$strSpace.'<td>', '\d{4}-\d{2}-\d{2}', '</td>'.$strSpace);
    	for ($i = 0; $i < 7; $i ++) $strPattern .= RegExpParenthesis('<td>', '[^<]*', '</td>'.$strSpace);
    	$strPattern .= $strBoundary;
    	$arMatch = array();
    	preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    	return $arMatch;
    }
    return false;
}

?>
