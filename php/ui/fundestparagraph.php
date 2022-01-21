<?php
require_once('stocktable.php');

// $ref from FundReference
function _echoFundEstTableItem($ref, $bFair)
{
    if (RefHasData($ref) == false)      return;

    $ar = array($ref->GetStockLink(), $ref->GetNav());
    
    $strOfficialPrice = $ref->GetOfficialNav();
    $ar[] = $ref->GetPriceDisplay($strOfficialPrice);
    $ar[] = $ref->GetPercentageDisplay($strOfficialPrice);
    
    if ($strFairPrice = $ref->GetFairNav())
    {
    	$ar[] = $ref->GetPriceDisplay($strFairPrice);
    	$ar[] = $ref->GetPercentageDisplay($strFairPrice);
    }
    else if ($bFair)
    {
    	$ar[] = '';
    	$ar[] =  '';
    }
    
    if (method_exists($ref, 'GetRealtimeNav'))
    {
    	if ($strRealtimePrice = $ref->GetRealtimeNav())
    	{
    		$ar[] = $ref->GetPriceDisplay($strRealtimePrice);
    		$ar[] = $ref->GetPercentageDisplay($strRealtimePrice);
    	}
    }
    
    EchoTableColumn($ar);
}

function _callbackSortFundEst($ref)
{
	$strNav = $ref->GetOfficialNav();
	if (method_exists($ref, 'GetStockRef'))
	{
    	$stock_ref = $ref->GetStockRef();
    	return $stock_ref->GetPercentage($strNav);
	}
	return $ref->GetPercentage($strNav);
}

function EchoFundArrayEstParagraph($arRef, $str = '')
{
	$iCount = count($arRef);
	if ($iCount > 2)
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
			$str .= ' '.CopySortLink('premium').'全部'.strval($iCount).'项';
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
        if ($ref->GetFairNav())
        {
        	$bFair = true;
        	$ar[] = new TableColumnEst(STOCK_DISP_FAIR);
        	$ar[] = $premium_col;
        	break;
        }
    }
	
    foreach ($arRef as $ref)
    {
    	if (method_exists($ref, 'GetRealtimeNav'))
    	{
    		if ($ref->GetRealtimeNav())
    		{
    			$ar[] = new TableColumnEst(STOCK_DISP_REALTIME);
    			$ar[] = $premium_col;
    			break;
    		}
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
	$str = GetTableColumnNetValue().$ref->GetDate().', ';
	$str .= GetTableColumnOfficalEst().$ref->GetOfficialDate().', 最近'.GetCalibrationHistoryLink($ref->GetSymbol()).$ref->GetTimeNow().'.';
    if ($ref->fRealtimeNetValue)
    {
    	$strRealtimeEst = GetTableColumnRealtimeEst();
    	$future_ref = $ref->GetFutureRef();
    	$future_etf_ref = $ref->future_etf_ref;
    	$est_ref = $ref->GetEstRef();
    
    	$strFutureSymbol = $future_ref->GetSymbol();
    	$str .= " 期货{$strRealtimeEst}{$strFutureSymbol}关联程度按照100%估算";
    
    	if ($future_etf_ref && ($future_etf_ref != $est_ref))
    	{
    		$strEtfSymbol = $est_ref->GetSymbol();
    		$strFutureEtfSymbol = $future_etf_ref->GetSymbol();
    		$str .= ', '.GetYahooNavLink($strEtfSymbol)."和{$strFutureEtfSymbol}关联程度按照100%估算";
    	}
    	$str .= '.';    
    }
    EchoFundArrayEstParagraph(array($ref), $str);
}

function EchoHoldingsEstParagraph($ref)
{
	$nav_ref = $ref->GetNavRef();
	$str = GetTableColumnNetValue().$nav_ref->GetDate().', ';
	$str .= GetTableColumnOfficalEst().$ref->GetOfficialDate().', ';
	$str .= GetHoldingsLink($ref->GetSymbol()).'更新于'.$ref->GetHoldingsDate().'.';
    EchoFundArrayEstParagraph(array($ref), $str);
}

?>
