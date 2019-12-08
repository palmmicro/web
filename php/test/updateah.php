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
*/

function _updateAh()
{
    $strUrl = GetAastocksUrl('ah');
    $str = url_get_contents($strUrl);

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
	$sql = new StockSql();
	$pair_sql = new AhPairSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode('.', $arItem[3]);
   		if (count($ar) == 2)
   		{
   			$strSymbolA = $ar[1].$ar[0];
   			if ($record = $sql->GetRecord($strSymbolA))
   			{
   				if (strpos($record['name'], '退市') === false)
   				{
   					$strStockIdA = $record['id'];
   					$strSymbolH = rtrim($arItem[2], '.HK');
   					$strStockIdH = $sql->GetId($strSymbolH);
   					if ($strStockIdH == false)
   					{
   						$sql->Insert($strSymbolH, $arItem[1]);
   						$strStockIdH = $sql->GetId($strSymbolH);
   					}
   					if ($strStockIdH)
   					{
   						if ($strIdH = $pair_sql->GetKeyId($strStockIdA))
   						{
   							if ($strIdH != $strStockIdH)
   							{
   								$pair_sql->Update($strStockIdA, $strStockIdH);
   								DebugString('Unusual Update: '.$strSymbolH.' '.$strSymbolA);
   								$iCount ++;
   							}
   						}
   						else
   						{
   							$pair_sql->Insert($strStockIdA, $strStockIdH);
   							DebugString($arItem[1].' '.$strSymbolH.' '.$strSymbolA);
   							$iCount ++;
   						}
   					}
   				}
   			}
   		}
   	}
    DebugVal($iCount, 'updated');
}
	
	AcctAdminCommand('_updateAh');

?>
