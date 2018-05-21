<?php
require_once('stocktable.php');

function GetDailyCloseByDate($ref, $strDate)
{
	if ($ref)
	{
		$sql = new SqlStockHistory($ref->GetStockId());
		if ($history = $sql->Get($strDate))
		{
			if ($history_prev = $sql->GetPrev($strDate))
			{
				return array($history['close'], $history_prev['close']);
			}
		}
	}
    return false;
}

function EchoFundHistoryTableItem($ref, $csv, $history, $fund, $arEtfClose)
{
	$strDate = $history['date'];
    $strFundClose = $history['close'];
    $strNetValue = $fund['netvalue'];
    $strEstValue = $fund['estimated'];
    $strEstTime = $fund['time'];
    
    $fNetValue = floatval($strNetValue);
    $fFundClose = floatval($strFundClose);
    $strNetValueDisplay = StockGetPriceDisplay($fNetValue, $fFundClose);
    $strPercentage = StockGetPercentageDisplay($fFundClose, $fNetValue);
    if ($csv && FloatNotZero($fNetValue))
    {
    	$csv->WriteArray(array($strDate, $strNetValue, strval(StockGetPercentage($fFundClose, $fNetValue))));
    }
    
    $strEtfClose = ''; 
    $strEtfChange = '';
    if ($arEtfClose)
    {
        list($strClose, $strPrevClose) = $arEtfClose;
        $strEtfClose = StockGetPriceDisplay(floatval($strClose), floatval($strPrevClose)); 
        $strEtfChange = StockGetPercentageDisplay(floatval($strClose), floatval($strPrevClose));
    }

    $strEstValueDisplay = '';
    $strError = ''; 
    if ($strEstValue != '0')
    {
        $fEstValue = floatval($strEstValue);
        $strEstValueDisplay = StockGetPriceDisplay($fEstValue, $fFundClose);
        if (FloatNotZero(GetEstErrorPercentage($fEstValue, $fNetValue)))
        {
            $strError = StockGetPercentageDisplay($fEstValue, $fNetValue);
        }
        else
        {
            $strError = '<font color=grey>0</font>'; 
        }
    }
    else
    {
        $strEstTime = '';
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strFundClose</td>
        <td class=c1>$strNetValueDisplay</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strEtfClose</td>
        <td class=c1>$strEtfChange</td>
        <td class=c1>$strEstValueDisplay</td>
        <td class=c1>$strEstTime</td>
        <td class=c1>$strError</td>
    </tr>
END;
}

function GetNextTradingDayYMD($strYMD)
{
    $ymd = new YMDString($strYMD);
    $iTick = $ymd->GetNextTradingDayTick();
    
    $ymd_next = new YMDTick($iTick);
    return $ymd_next->GetYMD();
}

function _echoHistoryTableData($fund, $csv, $etf_ref, $iStart, $iNum)
{
	$bSameDayNetValue	 = true;
	if ($etf_ref)
	{
		if ($etf_ref->sym->IsSymbolUS())		$bSameDayNetValue	 = false;
	}
	
    $strStockId = $fund->GetStockId();
    if ($result = SqlGetFundHistory($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if ($bSameDayNetValue)
            {
                $strDate = $record['date'];
            }
            else
            {
                $strDate = GetNextTradingDayYMD($record['date']);
            }
            
            if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
            {
            	$arEtfClose = GetDailyCloseByDate($etf_ref, $record['date']);
                EchoFundHistoryTableItem($ref, $csv, $history, $record, $arEtfClose);
            }
        }
        @mysql_free_result($result);
    }
}

function EchoFundHistoryTableBegin($arColumn)
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

function FundHistoryTableGetColumn($etf_ref, $bChinese)
{
    if ($etf_ref)
    {
        $strSymbol = GetMyStockRefLink($etf_ref, $bChinese);
        if ($bChinese)  $strChange = '涨跌';
        else              $strChange = 'Change';
    }
    else
    {
        $strSymbol = '';
        $strChange = '';
    }
    
	$arFundEst = GetFundEstTableColumn($bChinese);
	$arSma = GetSmaTableColumn($bChinese);
	$strPremium = $arSma[2];
    if ($bChinese)     
    {
        $arColumn = array('日期', '<font color=indigo>收盘价</font>', '<font color=olive>净值</font>', $strPremium, $strSymbol, $strChange, $arFundEst[1], '估值时间', '误差');
    }
    else
    {
        $arColumn = array('Date', '<font color=indigo>Close</font>', '<font color=olive>Net Value</font>', $strPremium, $strSymbol, $strChange, $arFundEst[1], 'Est Time', 'Error');
    }
    return $arColumn;
}

function EchoFundHistoryFullParagraph($fund, $csv, $iStart, $iNum, $bChinese)
{
	$etf_ref = $fund->etf_ref;
    $arColumn = FundHistoryTableGetColumn($etf_ref, $bChinese);
    $strSymbol = $fund->GetStockSymbol();
    $strSymbolLink = GetMyStockLink($strSymbol, $bChinese);
    if ($bChinese)     
    {
        $str = "{$strSymbolLink}历史{$arColumn[1]}相对于{$arColumn[2]}的{$arColumn[3]}";
    }
    else
    {
        $str = "The {$arColumn[3]} history of $strSymbolLink {$arColumn[1]} price comparing with {$arColumn[2]}";
    }
    
    if (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))
    {
        $str .= ' '.GetNetValueHistoryLink($strSymbol, $bChinese);
        $strNavLink = '';
    }
    else
    {
    	$iTotal = SqlCountFundHistory($fund->GetStockId());
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    }

    if (AcctIsDebug())		$str .= ' '.$fund->DebugLink();
    
    EchoParagraphBegin($str.' '.$strNavLink);
    EchoFundHistoryTableBegin($arColumn);
    _echoHistoryTableData($fund, $csv, $etf_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
}

function EchoFundHistoryParagraph($fund, $bChinese)
{
	EchoFundHistoryFullParagraph($fund, false, 0, TABLE_COMMON_DISPLAY, $bChinese);
}

?>
