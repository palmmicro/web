<?php
require_once('stocktable.php');

function _echoFundHistoryTableItem($csv, $strDate, $fNetValue, $fClose, $arFund, $ref)
{
    $strNetValue = strval($fNetValue);
    $strClose = StockGetPriceDisplay($fClose, $fNetValue);
    $strPremium = StockGetPercentageDisplay($fClose, $fNetValue);
    if ($csv)
    {
    	$csv->WriteArray(array($strDate, $strNetValue, strval(StockGetPercentage($fClose, $fNetValue))));
    }
    
    $strPairClose = ''; 
    $strPairChange = '';
    if ($ref)
    {
        $strPairClose = $ref->GetCurrentPriceDisplay();
        $strPairChange = $ref->GetCurrentPercentageDisplay();
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
        $fPercentage = StockGetEstErrorPercentage($fEstValue, $fNetValue);
        if (empty($fPercentage))
        {
            $strEstError = '<font color=grey>0</font>'; 
        }
        else
        {
            $strEstError = StockGetPercentageDisplay($fEstValue, $fNetValue);
        }
        $strEstValue = StockGetPriceDisplay($fEstValue, $fClose);
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

function _echoHistoryTableData($sql, $csv, $est_ref, $iStart, $iNum)
{
	$clone_ref = false;
	if ($est_ref)
	{
		$sym = $est_ref->GetSym();
		if ($sym->IsSinaFuture())			$bSameDayNetValue	 = true;
		else if ($sym->IsSymbolUS())		$bSameDayNetValue	 = false;
		else								$bSameDayNetValue	 = true;
		
		$est_sql = new StockHistorySql($est_ref->GetStockId());
		$clone_ref = clone $est_ref;
	}
	
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		if ($bSameDayNetValue)
        		{
        			$strDate = $arFund['date'];
        		}
        		else
        		{
        			$strDate = GetNextTradingDayYMD($arFund['date']);
        		}
            
        		if ($arStock = $sql->stock_sql->Get($strDate))
        		{
        			_echoFundHistoryTableItem($csv, $strDate, $fNetValue, floatval($arStock['close']), $arFund, RefGetDailyClose($clone_ref, $est_sql, $arFund['date']));
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
    
	$sql = new FundHistorySql($ref->GetStockId());
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
    _echoHistoryTableData($sql, $csv, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = '';
    if (AcctIsDebug())		$str .= ' '.$fund->DebugLink();
    _echoFundHistoryParagraph($fund->stock_ref, $fund->est_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

function EchoEtfHistoryParagraph($ref, $bChinese, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$str = '';
    if (AcctIsDebug())
    {
    	if ($ref->IsSymbolA())	$str .= ' '.$ref->nv_ref->DebugLink();
    }
    _echoFundHistoryParagraph($ref, $ref->pair_ref, $bChinese, $str, $csv, $iStart, $iNum);
}

?>
