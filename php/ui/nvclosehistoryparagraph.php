<?php
require_once('stocktable.php');

function _echoNvCloseItem($csv, $strDate, $fNetValue, $ref, $strFundId)
{
    $fChange = $ref->GetCurrentPercentage();
    $strChange = $ref->GetCurrentPercentageDisplay();
	
    $strNetValue = strval($fNetValue);
	$ref->SetPrice($strNetValue);
    $strClose = $ref->GetCurrentPriceDisplay();
   	$strPremium = $ref->GetCurrentPercentageDisplay();
   	if ($csv)	$csv->Write($strDate, strval($fChange), strval($ref->GetCurrentPercentage()), $strNetValue);
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_NAV_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
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

function _echoNvCloseData($sql, $ref, $csv, $iStart, $iNum, $bTest)
{
    $stock_sql = new StockHistorySql($ref->GetStockId());
	$clone_ref = clone $ref;
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $arFund['date'];
       			if ($stock_ref = RefGetDailyClose($clone_ref, $stock_sql, $strDate))
       			{
       				_echoNvCloseItem($csv, $strDate, $fNetValue, $stock_ref, ($bTest ? $arFund['id'] : false));
        		}
        	}
        }
        @mysql_free_result($result);
    }
}

function EchoNvCloseHistoryParagraph($ref, $str = false, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$sql = new NavHistorySql($ref->GetStockId());
	$iTotal = $sql->Count();
	if ($iTotal == 0)		return;
	
    $strSymbol = $ref->GetStockSymbol();
   	$strNavLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
   	if ($str == false)	$str = GetNvCloseHistoryLink($strSymbol);

    $arColumn = GetFundHistoryTableColumn($ref);
    echo <<<END
    <p>$strNavLink $str
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
