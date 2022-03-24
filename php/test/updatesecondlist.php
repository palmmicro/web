<?php
require_once('_commonupdatestock.php');

/*
<tr class="ahdata"> 
<td class="ahstock padl padr"><div style='padding:0px;'><span class='float_l'>第一拖拉機股份</span><span class='clear'></span></div></td> 
<td class="hshare padl padr cls"><div style='padding:0px;'><span class='float_l'><a href='/tc/stocks/quote/detail-quote.aspx?symbol=00038' class='a14 cls' title='00038.HK'>00038.HK</a></span><span class='float_l icon-ts icon-shhk pt jshoverwithclass' hover='icon-shhk-hover' style='margin-left:2px' onclick="window.location.href='/tc/cnhk/market/hk-connect.aspx'"></span><span class='clear'></span></div></td> 
<td class="hshare padr txt_r cls">1.810</td> 
<td class="hshare padr txt_r cls"><span class='pos'>+1.117%</span></td> 
<td class="ashare padl padr cls"><div style='padding:0px;'><span class='float_l'><a href='javascript:cnquote("601038")' class='a14 cls' title='601038.SH'>601038.SH</a></span><span class='float_l icon-ts icon-shhk pt jshoverwithclass' hover='icon-shhk-hover' style='margin-left:2px' onclick="window.location.href='/tc/cnhk/market/sh-connect.aspx'"></span><span class='clear'></span></div></td> 
<td class="ashare padr txt_r cls">7.74</td>
<td class="ashare padr txt_r cls"><span class='neg'>-1.023%</span></td> 
<td class="hashare padl padr txt_r cls"><span class='neg'>-79.477%</span></td> 
</tr>

<tbody> 
<tr> 
<td class="txt_l border-s" rowspan="2"><div class='float_l'>和黃醫藥</div><span class='float_l icon-ts icon-nc txt_c pt cls jshoverwithclass' market='HK' symbol='00013' hover='icon-nc-hover'>7</span></td> 
<td class="txt_c border-s cls" rowspan="2"><span class='neg'>低3.92%</span></td> 
<td class="txt_l cls padL"><div class="float_l"><div class="inline_block icon-flag-hk"></div><a href="/tc/stocks/quote/detail-quote.aspx?symbol=00013">00013.HK</a></div></td> 
<td class="txt_c"> <div class="txt_l inline_block nowrap la1">港元</div> <div class="txt_r inline_block nowrap la2 cls">31.500</div> <div class="txt_l inline_block nowrap la3">(美股折合</div> <div class="txt_r inline_block nowrap la4 cls">32.785)</div> </td> 
<td class="txt_r cls"><span class='neg'>-0.474%</span></td> 
<td class="txt_r cls"><span class='neg'>-24.55%</span></td> 
<td class="txt_r cls"><span class='neg'>-45.31%</span></td> 
<td class="no-border"></td> 
</tr> 
<tr> 
<td class="txt_l border-s padL cls"><div class="float_l"><div class="inline_block icon-flag-us"></div><a href="/tc/usq/quote/quote.aspx?symbol=HCM">HCM.US</a></div></td>
<td class="txt_c border-s"> <div class="txt_l inline_block nowrap la1">美元</div> <div class="txt_r inline_block nowrap la2 cls">20.945</div> <div class="txt_l inline_block nowrap la3">(港股折合</div> <div class="txt_r inline_block nowrap la4 cls">20.124)</div> </td> 
<td class="txt_r border-s cls"><span class='pos'>+5.729%</span></td> 
<td class="txt_r border-s cls"><span class='neg'>-22.34%</span></td> 
<td class="txt_r border-s cls"><span class='neg'>-40.67%</span></td> 
<td class="border-s"></td> 
</tr>

<tr> 
<td class="txt_l border-s" rowspan="2"><div class='float_l'>華住集團－Ｓ</div><span class='float_l icon-ts icon-nc txt_c pt cls jshoverwithclass' market='HK' symbol='01179' hover='icon-nc-hover'>1</span></td>
<td class="txt_c border-s cls" rowspan="2"><span class='neg'>低0.36%</span></td> 
<td class="txt_l cls padL"><div class="float_l"><div class="inline_block icon-flag-hk"></div><a href="/tc/stocks/quote/detail-quote.aspx?symbol=01179">01179.HK</a></div></td> 
<td class="txt_c"> <div class="txt_l inline_block nowrap la1">港元</div> <div class="txt_r inline_block nowrap la2 cls">25.650</div> <div class="txt_l inline_block nowrap la3">(美股折合</div> <div class="txt_r inline_block nowrap la4 cls">25.742)</div> </td> 
<td class="txt_r cls"><span class='pos'>+1.183%</span></td> 
<td class="txt_r cls"><span class='neg'>-22.82%</span></td> 
<td class="txt_r cls"><span class='neg'>-8.18%</span></td> 
<td class="no-border"></td> 
</tr> 
<tr> 
<td class="txt_l border-s padL cls"><div class="float_l"><div class="inline_block icon-flag-us"></div><a href="/tc/usq/quote/quote.aspx?symbol=HTHT">HTHT.US</a></div></td>
<td class="txt_c border-s"> <div class="txt_l inline_block nowrap la1">美元</div> <div class="txt_r inline_block nowrap la2 cls">32.890</div> <div class="txt_l inline_block nowrap la3">(港股折合</div> <div class="txt_r inline_block nowrap la4 cls">32.773)</div> </td> 
<td class="txt_r border-s cls"><span class='neg'>-3.094%</span></td> 
<td class="txt_r border-s cls"><span class='neg'>-20.59%</span></td> 
<td class="txt_r border-s cls"><span class='neg'>-11.70%</span></td> 
<td class="border-s"></td>
</tr>

<tr> 
<td class="txt_l border-s" rowspan="2"><div class='float_l'>理想汽車－Ｗ</div><span class='float_l icon-ts icon-nc txt_c pt cls jshoverwithclass' market='HK' symbol='02015' hover='icon-nc-hover'>1</span></td> 
<td class="txt_c border-s cls" rowspan="2"><span class='pos'>高1.10%</span></td> 
<td class="txt_l cls padL"><div class="float_l"><div class="inline_block icon-flag-hk"></div><a href="/tc/stocks/quote/detail-quote.aspx?symbol=02015">02015.HK</a></div></td> 
<td class="txt_c"> <div class="txt_l inline_block nowrap la1">港元</div> <div class="txt_r inline_block nowrap la2 cls">106.900</div> <div class="txt_l inline_block nowrap la3">(美股折合</div> <div class="txt_r inline_block nowrap la4 cls">105.735)</div> </td> 
<td class="txt_r cls"><span class='neg'>-1.019%</span></td>
<td class="txt_r cls"><span class='neg'>-4.64%</span></td> 
<td class="txt_r cls"><span class='neg'>-9.33%</span></td> 
<td class="no-border"></td> 
</tr> 
<tr> <td class="txt_l border-s padL cls"><div class="float_l"><div class="inline_block icon-flag-us"></div><a href="/tc/usq/quote/quote.aspx?symbol=LI">LI.US</a></div></td>
<td class="txt_c border-s"> <div class="txt_l inline_block nowrap la1">美元</div> <div class="txt_r inline_block nowrap la2 cls">27.020</div> <div class="txt_l inline_block nowrap la3">(港股折合</div> <div class="txt_r inline_block nowrap la4 cls">27.317)</div> </td>
<td class="txt_r border-s cls"><span class='neg'>-1.136%</span></td>
<td class="txt_r border-s cls"><span class='neg'>-2.10%</span></td>
<td class="txt_r border-s cls"><span class='neg'>-11.18%</span></td>
<td class="border-s"></td> 
</tr>

<tr> 
<td class="txt_l border-s" rowspan="2"><div class='float_l'>網易－Ｓ</div><span class='float_l icon-ts icon-nc txt_c pt cls jshoverwithclass' market='HK' symbol='09999' hover='icon-nc-hover'>3</span></td> 
<td class="txt_c border-s cls" rowspan="2"><span class='pos'>高0.72%</span></td> 
<td class="txt_l cls padL"><div class="float_l"><div class="inline_block icon-flag-hk"></div><a href="/tc/stocks/quote/detail-quote.aspx?symbol=09999">09999.HK</a></div><div class='highInd float_l' style='margin-left:2px; padding:0px 2px;'>10日高</div></td>
<td class="txt_c"> <div class="txt_l inline_block nowrap la1">港元</div> <div class="txt_r inline_block nowrap la2 cls">151.300</div> <div class="txt_l inline_block nowrap la3">(美股折合</div> <div class="txt_r inline_block nowrap la4 cls">150.223)</div> 
</td> <td class="txt_r cls"><span class='pos'>+3.915%</span></td> 
<td class="txt_r cls"><span class='pos'>+2.86%</span></td> 
<td class="txt_r cls"><span class='neg'>-1.11%</span></td> 
<td class="no-border"></td> 
</tr> 
<tr> 
<td class="txt_l border-s padL cls"><div class="float_l"><div class="inline_block icon-flag-us"></div><a href="/tc/usq/quote/quote.aspx?symbol=NTES">NTES.US</a></div></td> 
<td class="txt_c border-s"> <div class="txt_l inline_block nowrap la1">美元</div> <div class="txt_r inline_block nowrap la2 cls">95.970</div> <div class="txt_l inline_block nowrap la3">(港股折合</div> <div class="txt_r inline_block nowrap la4 cls">96.658)</div> </td> 
<td class="txt_r border-s cls"><span class='pos'>+1.330%</span></td> 
<td class="txt_r border-s cls"><span class='pos'>+4.82%</span></td> 
<td class="txt_r border-s cls"><span class='neg'>-1.91%</span></td> 
<td class="border-s"></td> 
</tr> 
</tbody> 
*/

function _updateAh()
{
    $strUrl = GetAastocksUrl('ah');
    $str = url_get_contents($strUrl);
    if ($str == false)	return;

    $strBoundary = RegExpBoundary();
    $strAll = RegExpAll();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('<td class="ahstock padl padr">'.RegExpSkip('<div[^>]*>').RegExpSkip('<span[^>]*>'), '[^<]*', '<');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('<td class="hshare padl padr cls">'.RegExpSkip('<div[^>]*>').RegExpSkip('<span[^>]*>').RegExpSkip('<a[^>]*>'), '[^<]*', '<');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('<td class="ashare padl padr cls">'.RegExpSkip('<div[^>]*>').RegExpSkip('<span[^>]*>').RegExpSkip('<a[^>]*>'), '[^<]*', '<');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateAh');
    $iCount = 0;
	$sql = GetStockSql();
	$pair_sql = new AhPairSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode('.', $arItem[3]);
   		if (count($ar) == 2)
   		{
   			$strSymbolA = $ar[1].$ar[0];

			$strSymbolH = rtrim($arItem[2], '.HK');
   			$sql->InsertSymbol($strSymbolA, $arItem[1]);
   			$sql->InsertSymbol($strSymbolH, $arItem[1]);
			if ($pair_sql->WriteSymbol($strSymbolA, $strSymbolH))
			{
				DebugString($arItem[1].' '.$strSymbolH.' '.$strSymbolA);
				$iCount ++;
			}
   		}
   	}
    DebugVal($iCount, 'AH updated');
}
	
   	$acct = new Account();
	$acct->AdminCommand('_updateAh');
?>
