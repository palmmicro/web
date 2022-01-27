<?php
require_once('yahoostock.php');

/*
function _webUpdateSinaHistory($his_sql, $strStockId, $sym)
{
    $oldest_ymd = new OldestYMD();
    $iYearOldest = $oldest_ymd->GetYear();
    
	$ymd = new NowYMD();
	$iYear = $ymd->GetYear();
	$iSeason = $ymd->GetSeason();
	$iTotal = 0;
	while ($iTotal < MAX_QUOTES_DAYS)
	{
        if ($str = SinaGetStockHistory($sym, $iYear, $iSeason))
        {
        	$arMatch = preg_match_sina_history($str);
        	foreach ($arMatch as $ar)
        	{
        		$his_sql->WriteHistory($strStockId, $ar[1], $ar[4], $ar[2], $ar[3], $ar[5], $ar[6]);
        		$iTotal ++;
        	}
        }
        
        $iSeason --;
		if ($iSeason == 0)
		{
			$iSeason = 4;
			$iYear --;
			if ($iYear < $iYearOldest)	break;
		}
	}
    DebugVal($iTotal, $sym->GetSymbol().' total');
}
*/

/*
<tbody data-reactid="50">
<tr class="BdT Bdc($seperatorColor) Ta(end) Fz(s) Whs(nw)" data-reactid="51">
<td class="Py(10px) Ta(start) Pend(10px)" data-reactid="52"><span data-reactid="53">Mar 12, 2021</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="54"><span data-reactid="55">275.00</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="56"><span data-reactid="57">295.50</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="58"><span data-reactid="59">267.27</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="60"><span data-reactid="61">273.07</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="62"><span data-reactid="63">273.07</span></td>
<td class="Py(10px) Pstart(10px)" data-reactid="64"><span data-reactid="65">17,423,058</span></td>
</tr>

<td class="Py(10px) Ta(start) Pend(10px)"><span>Apr 10, 2017</span></td>
<td class="Py(10px) Pstart(10px)"><span>150.16</span></td>
<td class="Py(10px) Pstart(10px)"><span>151.88</span></td>
<td class="Py(10px) Pstart(10px)"><span>149.52</span></td>
<td class="Py(10px) Pstart(10px)"><span>151.36</span></td>
<td class="Py(10px) Pstart(10px)"><span>140.39</span></td>
<td class="Py(10px) Pstart(10px)"><span>2,763,725</span></td>
*/

function preg_match_yahoo_history($str)
{
    $strBoundary = RegExpBoundary();
    
    $strPattern = $strBoundary;
//    $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Ta\(start\) Pend\(10px\)" data-reactid="\d*"><span data-reactid="\d*">', '[^<]*', '</span></td>');
    $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Ta\(start\) Pend\(10px\)"><span>', '[^<]*', '</span></td>');
    for ($i = 0; $i < 6; $i ++)
    {
//        $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Pstart\(10px\)" data-reactid="\d*">'.RegExpSkip('<span data-reactid="\d*">'), '[^<]*', RegExpSkip('</span>').'</td>');
        $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Pstart\(10px\)"><span>', '[^<]*', '</span></td>');
    }
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}

function _webUpdateYahooHistory($his_sql, $strStockId, $strYahooSymbol)
{
	$oldest_ymd = new OldestYMD();
    $iTime = time();
    $iTotal = 0;
    $iMax = 100;
    $iMaxSeconds = $iMax * SECONDS_IN_DAY;
    
    for ($k = 0; $k < MAX_QUOTES_DAYS; $k += $iMax)
    {
        $iTimeBegin = $iTime - $iMaxSeconds;
        $strUrl = YahooStockHistoryGetUrl($strYahooSymbol, $iTimeBegin, $iTime);
//    	DebugString($strUrl);
        if ($str = url_get_contents($strUrl))
        {
        	$arMatch = preg_match_yahoo_history($str);
        	$iVal = count($arMatch);
        	$iTotal += $iVal;
        	if ($iVal < $iMax / 2)
        	{
        		$begin_ymd = new TickYMD($iTimeBegin);
        		$ymd = new TickYMD($iTime);
        		DebugString(sprintf('_webUpdateYahooHistory %s %d from %s to %s', $strYahooSymbol, $iVal, $begin_ymd->GetYMD(), $ymd->GetYMD()));
        	}
        
        	for ($j = 0; $j < $iVal; $j ++)
        	{
        		$ymd = new TickYMD(strtotime($arMatch[$j][1]));
        		$strDate = $ymd->GetYMD();
        		if ($oldest_ymd->IsTooOld($strDate))	break;
            
        		$ar = array();
        		for ($i = 0; $i < 6; $i ++)
        		{
        			$strNoComma = str_replace(',', '', $arMatch[$j][$i + 2]); 
        			$ar[] = $strNoComma;
        		}
        		
        		if ($ar[3] == '-' || $ar[5] == '-')
        		{	// debug wrong data
        			DebugPrint($arMatch[$j]);
        		}
        		else if ($oldest_ymd->IsInvalid($strDate) === false)
        		{
        			$his_sql->WriteHistory($strStockId, $strDate, $ar[3], $ar[0], $ar[1], $ar[2], $ar[5], $ar[4]);
        		}
        	}
        }
        
        $iTime = $iTimeBegin;
    }
    DebugVal($iTotal, $strYahooSymbol.' total');
}

function UpdateStockHistory($sym, $strStockId)
{
    $his_sql = GetStockHistorySql();
    $sym->SetTimeZone();
    
	if ($sym->IsIndexA())
	{
//		_webUpdateSinaHistory($his_sql, $strStockId, $sym);
	}
	else
	{
		_webUpdateYahooHistory($his_sql, $strStockId, $sym->GetYahooSymbol());
		if ($sym->IsSymbolA() || $sym->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
//			if ($ref->IsIndex() == false)
			{
				$his_sql->DeleteByZeroVolume($strStockId);
			}
		}
	}
    unlinkConfigFile($sym->GetSymbol());
}

?>
