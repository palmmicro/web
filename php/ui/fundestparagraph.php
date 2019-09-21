<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref)
{
    if (RefHasData($ref) == false)      return;
    
    $strLink = GetEastMoneyFundLink($ref->GetSym());
    $strPrice = $ref->GetNetValue();
    
    $strOfficialPrice = $ref->GetOfficialNetValue();
    $strOfficialPremium = $ref->GetPercentageDisplay($strOfficialPrice);
    $strOfficialPrice = $ref->GetPriceDisplay($strOfficialPrice);
    
    if ($strFairPrice = $ref->GetFairNetValue())
    {
    	$strFairPremium = $ref->GetPercentageDisplay($strFairPrice);
    	$strFairPrice = $ref->GetPriceDisplay($strFairPrice);
    }
    else
    {
    	$strFairPremium = '';
    	$strFairPrice =  '';
    }
    
    if ($strRealtimePrice = $ref->GetRealtimeNetValue())
    {
    	$strRealtimePremium = $ref->GetPercentageDisplay($strRealtimePrice);
    	$strRealtimePrice = $ref->GetPriceDisplay($strRealtimePrice);
    }
    else
    {
    	$strRealtimePremium = '';
    	$strRealtimePrice =  '';
    }
    
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
//	$offical_col = new TableColumnEst();
//	$offical_col->AddPrefix(STOCK_DISP_OFFICIAL);

	$fair_col = new TableColumnEst();
	$fair_col->AddPrefix(STOCK_DISP_FAIR);

	$realtime_col = new TableColumnEst();
	$realtime_col->AddPrefix(STOCK_DISP_REALTIME);

	$premium_col = new TableColumnPremium();
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnNetValue(),
								   new TableColumnOfficalEst(),
								   $premium_col,
								   $fair_col,
								   $premium_col,
								   $realtime_col,
								   $premium_col), 'estimation', $str);

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
