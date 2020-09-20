<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref, $bFair)
{
    if (RefHasData($ref) == false)      return;

    $ar = array($ref->GetStockLink(), $ref->GetNetValue());
    
    $strOfficialPrice = $ref->GetOfficialNetValue();
    $ar[] = $ref->GetPriceDisplay($strOfficialPrice);
    $ar[] = $ref->GetPercentageDisplay($strOfficialPrice);
    
    if ($strFairPrice = $ref->GetFairNetValue())
    {
    	$ar[] = $ref->GetPriceDisplay($strFairPrice);
    	$ar[] = $ref->GetPercentageDisplay($strFairPrice);
    }
    else if ($bFair)
    {
    	$ar[] = '';
    	$ar[] =  '';
    }
    
    if ($strRealtimePrice = $ref->GetRealtimeNetValue())
    {
    	$ar[] = $ref->GetPriceDisplay($strRealtimePrice);
    	$ar[] = $ref->GetPercentageDisplay($strRealtimePrice);
    }
    
    EchoTableColumn($ar);
}

function _getFundRealtimeStr($ref, $strRealtimeEst)
{
    $future_ref = $ref->future_ref;
    $future_etf_ref = $ref->future_etf_ref;
   	$est_ref = $ref->GetEstRef();
    
    $strFutureSymbol = $future_ref->GetSymbol();
    $str = "期货{$strRealtimeEst}{$strFutureSymbol}关联程度按照100%估算";
    
    if ($future_etf_ref && ($future_etf_ref != $est_ref))
    {
        $strEtfSymbol = $est_ref->GetSymbol();
        $strFutureEtfSymbol = $future_etf_ref->GetSymbol();
        $str .= ", {$strEtfSymbol}和{$strFutureEtfSymbol}关联程度按照100%估算";
    }
    return $str.'.';    
}

function _getFundParagraphStr($ref)
{
    $strDate = $ref->GetOfficialDate();
    $strLastTime = SqlGetStockCalibrationTime($ref->GetStockId());
    $strHistoryLink = GetCalibrationHistoryLink($ref->GetSymbol());
	$str = GetTableColumnOfficalEst();
    $str .= GetTableColumnDate().$strDate.", 校准时间($strHistoryLink)$strLastTime.";
    if ($ref->fRealtimeNetValue)   $str .= ' '._getFundRealtimeStr($ref, GetTableColumnRealtimeEst());
    return $str;
}

function _callbackSortFundEst($ref)
{
	return $ref->stock_ref->GetPercentage($ref->GetOfficialNetValue());
}

function EchoFundArrayEstParagraph($arRef, $str = '')
{
	if (count($arRef) > 2)
	{
		if ($strSort = UrlGetQueryValue('sort'))
		{
			if ($strSort == 'premium')
			{
				$arRef = RefSortByNumeric($arRef, '_callbackSortFundEst');
			}
		}
		else
		{
			$str .= ' '.CopySortLink('premium');
		}
	}
	
	$premium_col = new TableColumnPremium();
	$ar = array(new TableColumnSymbol(),
				  new TableColumnNetValue(),
				  new TableColumnOfficalEst(),
				  $premium_col);
	
	$bFair = false;
    foreach ($arRef as $ref)
    {
        if ($ref->GetFairNetValue())
        {
        	$bFair = true;
        	$ar[] = new TableColumnEst(STOCK_DISP_FAIR);
        	$ar[] = $premium_col;
        	break;
        }
    }
	
    foreach ($arRef as $ref)
    {
        if ($ref->GetRealtimeNetValue())
        {
        	$ar[] = new TableColumnEst(STOCK_DISP_REALTIME);
        	$ar[] = $premium_col;
        	break;
        }
    }
	
	EchoTableParagraphBegin($ar, 'estimation', $str);
    foreach ($arRef as $ref)
    {
        _echoFundEstTableItem($ref, $bFair);
    }
    EchoTableParagraphEnd();
}

function EchoFundEstParagraph($ref)
{
    $str = _getFundParagraphStr($ref);
    EchoFundArrayEstParagraph(array($ref), $str);
}

?>
