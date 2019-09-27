<?php
require_once('stocktable.php');

function _echoNvCloseItem($csv, $shares_sql, $strDate, $strNetValue, $ref, $strFundId)
{
	$his_sql = $ref->GetHistorySql();
	$strClose = $his_sql->GetClose($strDate);
	$strClosePrev = $his_sql->GetClosePrev($strDate);
	if (($strClose === false) || ($strClosePrev === false))	return;
	
   	if ($csv)	$csv->Write($strDate, $ref->GetPercentage($strClosePrev, $strClose), $ref->GetPercentage($strNetValue, $strClose), $strNetValue);
   	
    $strChange = $ref->GetPercentageDisplay($strClosePrev, $strClose);
   	$strPremium = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $strClose = $ref->GetPriceDisplay($strClose, $strNetValue);
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_NETVALUE_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
    }
    
    if ($strShares = $shares_sql->GetClose($strDate))
    {
    	$strShares = rtrim0($strShares);
    	$fVolume = floatval($his_sql->GetVolume($strDate));
    	$strChangeRate = strval_round(100.0 * $fVolume / (floatval($strShares * 10000.0)));
    }
    else
    {
    	$strShares = '';
    	$strChangeRate = '';
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strChange</td>
        <td class=c1>$strShares</td>
        <td class=c1>$strChangeRate</td>
    </tr>
END;
}

function _echoNvCloseData($sql, $shares_sql, $ref, $csv, $iStart, $iNum, $bAdmin)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
   				_echoNvCloseItem($csv, $shares_sql, $record['date'], $strNetValue, $ref, ($bAdmin ? $record['id'] : false));
        	}
        }
        @mysql_free_result($result);
    }
}

function EchoNvCloseHistoryParagraph($ref, $str = false, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
	$strStockId = $ref->GetStockId();
	$sql = new NetValueHistorySql($strStockId);
	$iTotal = $sql->Count();
	if ($iTotal == 0)		return;

    $strSymbol = $ref->GetStockSymbol();
   	$strNavLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
   	if ($str == false)	$str = GetNvCloseHistoryLink($strSymbol);

	$str .= ' '.$strNavLink;
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium(),
								   new TableColumnChange(),
								   new TableColumn('流通股数(万)', 100),
								   new TableColumn('换手率(%)', 90)
								   ), $strSymbol.'nvclosehistory', $str);

	$shares_sql = new EtfSharesHistorySql($strStockId);
    _echoNvCloseData($sql, $shares_sql, $ref, $csv, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

?>
