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

    $fEstValue = floatval($arFund['estimated']);
    if (empty($fEstValue))
    {
    	$strEstError = ''; 
    	$strEstValue = '';
        $strEstTime = '';
    }
    else
    {
        $ref->SetCurrentPrice($strNetValue);
        $strEstError = $ref->GetPercentageDisplay($fEstValue);
        $strEstValue = $ref->GetPriceDisplay($fEstValue, false);
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
	if ($est_ref)
	{
		$bSameDayNetValue	 = true;
		$sym = $est_ref->GetSym();
		if ($sym->IsSinaFuture())			{}
		else if ($sym->IsSymbolUS())
		{
			if ($ref->IsSymbolA())		$bSameDayNetValue	 = false;
		}
		
		$est_sql = new StockHistorySql($est_ref->GetStockId());
		$clone_est_ref = clone $est_ref;
	}
	
	$fund_sql = new FundHistorySql($ref->GetStockId());
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($arNav = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arNav['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $arNav['date'];
        		$arFund = $fund_sql->Get($strDate);
        		if ($bSameDayNetValue == false)
        		{
        			$strDate = GetNextTradingDayYMD($strDate);
        		}
            
        		if ($arStock = $fund_sql->stock_sql->Get($strDate))
        		{
       				$clone_ref->SetPrice(strval($fNetValue), $arStock['close']);
        			_echoFundHistoryTableItem($csv, $strDate, $arFund, $clone_ref, RefGetDailyClose($clone_est_ref, $est_sql, $arFund['date']));
        		}
        	}
        }
        @mysql_free_result($result);
    }
}

function _echoFundHistoryTableBegin($arColumn)
{
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="history">
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
}

function _echoFundHistoryParagraph($ref, $est_ref, $bChinese, $strDisplay = '', $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
    $arColumn = GetFundHistoryTableColumn($est_ref, $bChinese);
    $strSymbol = $ref->GetStockSymbol();
    $strSymbolLink = GetMyStockLink($strSymbol, $bChinese);
    if ($bChinese)     
    {
        $str = "{$strSymbolLink}历史{$arColumn[1]}相对于{$arColumn[2]}的{$arColumn[3]}";
    }
    else
    {
        $str = "The {$arColumn[3]} history of $strSymbolLink {$arColumn[1]} price comparing with {$arColumn[2]}";
    }
    
	$sql = new NavHistorySql($ref->GetStockId());
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str .= ' '.GetNetValueHistoryLink($strSymbol, $bChinese);
        $strNavLink = '';
    }
    else
    {
    	$iTotal = $sql->Count();
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    }

    EchoParagraphBegin($str.' '.$strNavLink.' '.$strDisplay);
    _echoFundHistoryTableBegin($arColumn);
    _echoHistoryTableData($sql, $csv, $ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = '';
    if (AcctIsTest($bChinese))
    {
    	$str .= ' '.$fund->DebugLink();
    }
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = '';
    if (AcctIsTest($bChinese))
    {
    	if ($ref->IsSymbolA())	$str .= ' '.$ref->nv_ref->DebugLink();
    }
    _echoFundHistoryParagraph($ref, $ref->pair_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

?>
