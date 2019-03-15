<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref, $bChinese)
{
    if (StockRefHasData($ref) == false)      return;
    
    $strLink = GetEastMoneyFundLink($ref->GetSym());
    $strOfficialPrice = $ref->GetPriceDisplay($ref->fOfficialNetValue, false);
    $strOfficialPremium = $ref->GetPercentageDisplay($ref->fOfficialNetValue);
    $strFairPrice = $ref->GetPriceDisplay($ref->fFairNetValue, false);
    $strFairPremium = $ref->GetPercentageDisplay($ref->fFairNetValue);
    $strRealtimePrice = $ref->GetPriceDisplay($ref->fRealtimeNetValue, false);
    $strRealtimePremium = $ref->GetPercentageDisplay($ref->fRealtimeNetValue);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strOfficialPrice</td>
        <td class=c1>$strOfficialPremium</td>
        <td class=c1>$strFairPrice</td>
        <td class=c1>$strFairPremium</td>
        <td class=c1>$strRealtimePrice</td>
        <td class=c1>$strRealtimePremium</td>
    </tr>
END;
}

function _getFundRealtimeStr($ref, $strRealtimeEst, $bChinese)
{
    $future_ref = $ref->future_ref;
    $future_etf_ref = $ref->future_etf_ref;
    $est_ref = $ref->est_ref;
    
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

function _getFundParagraphStr($ref, $bChinese)
{
    $strDate = $ref->strOfficialDate;
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
    if ($ref->fRealtimeNetValue)   $str .= ' '._getFundRealtimeStr($ref, $arColumn[5], $bChinese);
    return $str;
}

function EchoFundArrayEstParagraph($arRef, $bChinese = true, $str = '')
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

function EchoFundEstParagraph($ref, $bChinese = true)
{
    $str = _getFundParagraphStr($ref, $bChinese);
    EchoFundArrayEstParagraph(array($ref), $bChinese, $str);
}

?>
