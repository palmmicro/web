<?php
require_once('stocktable.php');

function _echoFundHistoryTableItem($csv, $strDate, $arFund, $ref, $est_ref)
{
    $strNetValue = $ref->GetPrevPrice();
    $strClose = $ref->GetCurrentPriceDisplay();
    $strPremium = $ref->GetCurrentPercentageDisplay();
    if ($csv)
    {
    	$csv->Write($strDate, $strNetValue, strval($ref->GetCurrentPercentage()));
    }
    
    $strPairClose = ''; 
    $strPairChange = '';
    if ($est_ref)
    {
        $strPairClose = $est_ref->GetCurrentPriceDisplay();
        $strPairChange = $est_ref->GetCurrentPercentageDisplay();
    }

    $strEstValue = $arFund['close'];
    if (empty($strEstValue))
    {
    	$strEstError = ''; 
    	$strEstValue = '';
        $strEstTime = '';
    }
    else
    {
        $ref->SetCurrentPrice($strNetValue);
        $strEstError = $ref->GetPercentageDisplay($strEstValue);
        $strEstValue = $ref->GetPriceDisplay($strEstValue, false);
        $strEstTime = $arFund['time'];
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strPairClose</td>
        <td class=c1>$strPairChange</td>
        <td class=c1>$strEstValue</td>
        <td class=c1>$strEstTime</td>
        <td class=c1>$strEstError</td>
    </tr>
END;
}

function _echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum)
{
	$clone_ref = clone $ref;
	$clone_est_ref = false;
	$bSameDayNetValue	 = true;
	if (RefHasData($est_ref))
	{
		$sym = $est_ref->GetSym();
		if ($sym->IsSinaFuture())			{}
		else if ($sym->IsSymbolUS())
		{
			if ($ref->sym->IsSymbolA())		$bSameDayNetValue	 = false;
		}
		
		$clone_est_ref = clone $est_ref;
	}
	
	$strStockId = $ref->GetStockId();
	$fund_sql = new FundEstSql($strStockId);
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($record['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $record['date'];
        		$arFund = $fund_sql->Get($strDate);
        		if ($bSameDayNetValue == false)
        		{
        			$strDate = GetNextTradingDayYMD($strDate);
        		}
            
        		if ($strClose = $ref->his_sql->GetClose($strDate))
        		{
       				$clone_ref->SetPrice(strval($fNetValue), $strClose);
        			_echoFundHistoryTableItem($csv, $strDate, $arFund, $clone_ref, RefGetDailyClose($clone_est_ref, $arFund['date']));
        		}
        	}
        }
        @mysql_free_result($result);
    }
}

function _echoFundHistoryParagraph($ref, $est_ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    $arColumn = GetFundHistoryTableColumn($est_ref);
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetMyStockLink($strSymbol);
    $str = "{$strSymbolLink}历史{$arColumn[1]}相对于{$arColumn[2]}的{$arColumn[3]}";
    
	$sql = new NetValueHistorySql($ref->GetStockId());
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetNetValueHistoryLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
    }

    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="fundhistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=60 align=center>{$arColumn[1]}</td>
        <td class=c1 width=60 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=60 align=center>{$arColumn[5]}</td>
        <td class=c1 width=70 align=center>{$arColumn[6]}</td>
        <td class=c1 width=80 align=center>{$arColumn[7]}</td>
        <td class=c1 width=60 align=center>{$arColumn[8]}</td>
    </tr>
END;

	_echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    _echoFundHistoryParagraph($ref, $ref->pair_ref, $csv, $iStart, $iNum);
}

?>
