<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref)
{
    if (RefHasData($ref) == false)      return;
    
    $strLink = GetEastMoneyFundLink($ref->GetSym());
    $strPrice = $ref->GetCurPrice();
    $strOfficialPrice = $ref->GetPriceDisplay($ref->GetOfficialNetValue(), false);
    $strOfficialPremium = $ref->GetPercentageDisplay($ref->GetOfficialNetValue());
    $strFairPrice = $ref->GetPriceDisplay($ref->GetFairNetValue(), false);
    $strFairPremium = $ref->GetPercentageDisplay($ref->GetFairNetValue());
    $strRealtimePrice = $ref->GetPriceDisplay($ref->GetRealtimeNetValue(), false);
    $strRealtimePremium = $ref->GetPercentageDisplay($ref->GetRealtimeNetValue());
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strPrice</td>
        <td class=c1>$strOfficialPrice</td>
        <td class=c1>$strOfficialPremium</td>
        <td class=c1>$strFairPrice</td>
        <td class=c1>$strFairPremium</td>
        <td class=c1>$strRealtimePrice</td>
        <td class=c1>$strRealtimePremium</td>
    </tr>
END;
}

function _getFundRealtimeStr($ref, $strRealtimeEst)
{
    $future_ref = $ref->future_ref;
    $future_etf_ref = $ref->future_etf_ref;
    $est_ref = $ref->est_ref;
    
    $strFutureSymbol = $future_ref->GetStockSymbol();
    $str = "期货{$strRealtimeEst}{$strFutureSymbol}关联程度按照100%估算";
    
    if ($future_etf_ref && ($future_etf_ref != $est_ref))
    {
        $strEtfSymbol = $est_ref->GetStockSymbol();
        $strFutureEtfSymbol = $future_etf_ref->GetStockSymbol();
        $str .= ", {$strEtfSymbol}和{$strFutureEtfSymbol}关联程度按照100%估算";
    }
    return $str.'.';    
}

function _getFundParagraphStr($ref)
{
    $strDate = $ref->strOfficialDate;
    $strLastTime = SqlGetStockCalibrationTime($ref->GetStockId());
    $strHistoryLink = GetCalibrationHistoryLink($ref->GetStockSymbol());
	$str = GetTableColumnOfficalEst();
    $str .= GetTableColumnDate().$strDate.", 校准时间($strHistoryLink)$strLastTime.";
    if ($ref->fRealtimeNetValue)   $str .= ' '._getFundRealtimeStr($ref, GetTableColumnRealtimeEst());
    return $str;
}

function EchoFundArrayEstParagraph($arRef, $str = '')
{
	$arColumn = array(GetTableColumnSymbol(), GetTableColumnNetValue(), GetTableColumnOfficalEst(), GetTableColumnOfficalPremium(), GetTableColumnFairEst(), GetTableColumnFairPremium(), GetTableColumnRealtimeEst(), GetTableColumnRealtimePremium());
    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="estimation">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=80 align=center>{$arColumn[1]}</td>
            <td class=c1 width=80 align=center>{$arColumn[2]}</td>
            <td class=c1 width=80 align=center>{$arColumn[3]}</td>
            <td class=c1 width=80 align=center>{$arColumn[4]}</td>
            <td class=c1 width=80 align=center>{$arColumn[5]}</td>
            <td class=c1 width=80 align=center>{$arColumn[6]}</td>
            <td class=c1 width=80 align=center>{$arColumn[7]}</td>
        </tr>
END;

    foreach ($arRef as $ref)
    {
        _echoFundEstTableItem($ref);
    }
    EchoTableParagraphEnd();
}

function EchoFundEstParagraph($ref)
{
    $str = _getFundParagraphStr($ref);
    EchoFundArrayEstParagraph(array($ref), $str);
}

?>
