<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref, $bChinese)
{
    if ($ref == false)                  return;
    if ($ref->bHasData == false)        return;
    
    $stock_ref = $ref->stock_ref;
    $strLink = GetChinaFundLink($stock_ref->sym);
    $strPrice = $stock_ref->GetPriceDisplay($ref->fPrice);
    $strPremium = $stock_ref->GetPercentageDisplay($ref->fPrice);
    $strFairPrice = $stock_ref->GetPriceDisplay($ref->fFairNetValue);
    $strFairPremium = $stock_ref->GetPercentageDisplay($ref->fFairNetValue);
    $strRealtimePrice = $stock_ref->GetPriceDisplay($ref->fRealtimeNetValue);
    $strRealtimePremium = $stock_ref->GetPercentageDisplay($ref->fRealtimeNetValue);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strFairPrice</td>
        <td class=c1>$strFairPremium</td>
        <td class=c1>$strRealtimePrice</td>
        <td class=c1>$strRealtimePremium</td>
    </tr>
END;
}

function _getFundRealtimeStr($fund, $strRealtimeEst, $bChinese)
{
    $future_ref = $fund->future_ref;
    $future_etf_ref = $fund->future_etf_ref;
    $est_ref = $fund->est_ref;
    
    $strFutureSymbol = $future_ref->GetStockSymbol();
    if ($bChinese)
    {
        $str = "期货{$strRealtimeEst}{$strFutureSymbol}关联程度按照100%估算";
    }
    else
    {
        $str = "Future $strRealtimeEst assume $strFutureSymbol 100%  related";
    }
    
    if ($future_etf_ref && ($future_etf_ref != $est_ref))
    {
        $strEtfSymbol = $est_ref->GetStockSymbol();
        $strFutureEtfSymbol = $future_etf_ref->GetStockSymbol();
        if ($bChinese)
        {
            $str .= ", {$strEtfSymbol}和{$strFutureEtfSymbol}关联程度按照100%估算";
        }
        else
        {
            $str .= ", assume $strEtfSymbol and $strFutureEtfSymbol 100% related";
        }
    }
    return $str.'.';    
}

function _getFundParagraphStr($fund, $bChinese)
{
    $ref = $fund->stock_ref;
    $strDate = $fund->strOfficialDate;
    $strLastTime = SqlGetStockCalibrationTime($ref->GetStockId());
    $strHistoryLink = GetCalibrationHistoryLink($ref->GetStockSymbol(), $bChinese);
	$arColumn = GetFundEstTableColumn($bChinese);
	$str = $arColumn[1];
    if ($bChinese)     
    {
        $str .= '日期'.$strDate.", 校准时间($strHistoryLink)$strLastTime.";
    }
    else
    {
        $str .= ' date '.$strDate.", calibration($strHistoryLink) on $strLastTime.";
    }
    if ($fund->fRealtimeNetValue)   $str .= ' '._getFundRealtimeStr($fund, $arColumn[5], $bChinese);
    return $str;
}

function EchoFundArrayEstParagraph($arRef, $bChinese, $str = '')
{
	$arColumn = GetFundEstTableColumn($bChinese);
    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=560 border=1 class="text" id="estimation">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=80 align=center>{$arColumn[1]}</td>
            <td class=c1 width=80 align=center>{$arColumn[2]}</td>
            <td class=c1 width=80 align=center>{$arColumn[3]}</td>
            <td class=c1 width=80 align=center>{$arColumn[4]}</td>
            <td class=c1 width=80 align=center>{$arColumn[5]}</td>
            <td class=c1 width=80 align=center>{$arColumn[6]}</td>
        </tr>
END;

    foreach ($arRef as $ref)
    {
        _echoFundEstTableItem($ref, $bChinese);
    }
    EchoTableParagraphEnd();
}

function EchoFundEstParagraph($fund, $bChinese)
{
    $str = _getFundParagraphStr($fund, $bChinese);
    EchoFundArrayEstParagraph(array($fund), $bChinese, $str);
}

?>
