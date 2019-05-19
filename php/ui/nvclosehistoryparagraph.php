<?php
require_once('stocktable.php');

function _echoNvCloseItem($csv, $strDate, $strNetValue, $ref, $strFundId)
{
	$his_sql = $ref->GetHistorySql();
	$strClose = $his_sql->GetClose($strDate);
	$strClosePrev = $his_sql->GetClosePrev($strDate);
	if (($strClose === false) || ($strClosePrev === false))	return;
	
   	if ($csv)	$csv->Write($strDate, strval($ref->GetPercentage($strClosePrev, $strClose)), strval($ref->GetPercentage($strNetValue, $strClose)), $strNetValue);
   	
    $strChange = $ref->GetPercentageDisplay($strClosePrev, $strClose);
   	$strPremium = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $strClose = $ref->GetPriceDisplay($strClose, $strNetValue);
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_NETVALUE_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strChange</td>
    </tr>
END;
}

function _echoNvCloseData($sql, $ref, $csv, $iStart, $iNum, $bAdmin)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
   				_echoNvCloseItem($csv, $record['date'], $strNetValue, $ref, ($bAdmin ? $record['id'] : false));
        	}
        }
        @mysql_free_result($result);
    }
}

function EchoNvCloseHistoryParagraph($ref, $str = false, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$sql = new NetValueHistorySql($ref->GetStockId());
	$iTotal = $sql->Count();
	if ($iTotal == 0)		return;
	
    $strSymbol = $ref->GetStockSymbol();
   	$strNavLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
   	if ($str == false)	$str = GetNvCloseHistoryLink($strSymbol);

    $arColumn = GetFundHistoryTableColumn($ref);
    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=500 border=1 class="text" id="{$strSymbol}nvclosehistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=100 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=100 align=center>{$arColumn[3]}</td>
        <td class=c1 width=100 align=center>{$arColumn[5]}</td>
    </tr>
END;
   
    _echoNvCloseData($sql, $ref, $csv, $iStart, $iNum, AcctIsAdmin());
    EchoTableParagraphEnd($strNavLink);
}

?>
