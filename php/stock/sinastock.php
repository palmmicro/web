<?php

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
    	$str = GbToUtf8($str);

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
