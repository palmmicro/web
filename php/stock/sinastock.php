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
    $str = url_get_contents($strUrl); 
    return $str;
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
			
function TestSinaStockHistory($strSymbol)
{
	$sym = new StockSymbol($strSymbol);
	$str = SinaGetStockHistory($sym);
	$arMatch = preg_match_sina_history($str);
	foreach ($arMatch as $ar)
	{
		$str = $ar[1];
		for ($i = 2; $i < count($ar); $i ++)
		{
			$str .= ' '.$ar[$i];
		}
		DebugString($str);
	}
	return $str;
}

//[{symbol:"sh600000",code:"600000",name:"浦发银行",trade:"12.890",pricechange:"-0.030",changepercent:"-0.232",buy:"12.890",sell:"12.900",settlement:"12.920",open:"12.930",high:"13.010",low:"12.740",volume:80197701,amount:1034450236,ticktime:"15:00:00",per:5.362,pb:0.796,mktcap:36225751.665811,nmc:36225751.665811,turnoverratio:0.28536},
//http://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page=1&num=100&sort=symbol&asc=1&node=hs_a&symbol=&_s_r_a=init
function SinaGetAllStockA($iPage)
{
    $strPage = strval($iPage);
    $strUrl = 'http://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page='.$strPage.'&num=100&sort=symbol&asc=1&node=hs_a&symbol=&_s_r_a=init';
    $str = url_get_contents($strUrl);
    $str = FromGB2312ToUTF8($str);
    return $str;
}

function _sina_str_replace_for_json_decode($str)
{
    $strNew = '';
    $bQuotation = false;
   
    for ($i = 0; $i < strlen($str); $i ++)
    {
        $strChar = substr($str, $i, 1);
        if ($strChar == '"')
        {
            if ($bQuotation)   $bQuotation = false;
            else                 $bQuotation = true; 
        }
        else if ($strChar == ':')
        {
            if ($bQuotation == false)   $strNew .= '"';
        }
        else if ($strChar == '{' || $strChar == ',')
        {
            $strNew .= $strChar.'"';
            continue;
        }
        $strNew .= $strChar;
    }
    return $strNew;
}

function SinaGetAllStockArrayA()
{
    $ar = array();
    $iPage = 1;
    do
    {
        $str = SinaGetAllStockA($iPage);
        $strBoundary = RegExpBoundary();
    
        $strPattern = $strBoundary;
        $strPattern .= RegExpParenthesis('{symbol:"', '[^"]*', '",code:"\d{6}",[^}]+}');
        $strPattern .= $strBoundary;
    
        $arMatch = array();
        $iVal = preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
        for ($j = 0; $j < $iVal; $j ++)
        {
            $strSymbol = strtoupper($arMatch[$j][1]);
            $strJson = _sina_str_replace_for_json_decode($arMatch[$j][0]); 
            $ar[$strSymbol] = json_decode($strJson, true);
        }

        set_time_limit(0);
        DebugString(strval($iPage).':'.strval($iVal));
        if ($iVal == 100)
        {
            $iPage ++;
        }
        else
        {
            if ($iPage > 32)    break;
        }
    } while (1);
    return $ar;
}

/*
function SinaGetAllStockSymbolA()
{
    $ar = array();
    $str = SinaGetAllStockA();
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('{symbol:"', '[^"]*', '",code:"\d{6}",');
    $strPattern .= RegExpParenthesis('name:"', '[^"]*', '",trade:"');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    $iVal = preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    for ($j = 0; $j < $iVal; $j ++)
    {
        $strSymbol = $arMatch[$j][1];
        $ar[$strSymbol] = $arMatch[$j][2];
    }
    return $ar;
}
*/

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
    $strUrl = SinaGetStockDividendUrl($strSymbol);
    $str = url_get_contents($strUrl);
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

// http://vip.stock.finance.sina.com.cn/corp/go.php/vISSUE_ShareBonus/stockid/000028.phtml
// http://stock.finance.sina.com.cn/hkstock/dividends/00386.html
function SinaGetStockDividendUrl($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($strDigit = $sym->IsSymbolA())
    {
    	return "http://vip.stock.finance.sina.com.cn/corp/go.php/vISSUE_ShareBonus/stockid/$strDigit.phtml";
    }
    return '(Empty)';
}

?>
