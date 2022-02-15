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
    	$ar[] = '';
    }
    
    if (method_exists($ref, 'GetRealtimeNav'))
    {
    	if ($strRealtimePrice = $ref->GetRealtimeNav())
    	{
    		$ar[] = $ref->GetPriceDisplay($strRealtimePrice);
    		$ar[] = $ref->GetPercentageDisplay($strRealtimePrice);
    	}
    }
    
    EchoTableColumn($ar, false, RefGetDescription($ref));
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

function _getFundEstTableColumn($arRef, &$bFair)
{
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
    return $ar;
}

function _echoFundEstParagraph($arColumn, $bFair, $arRef, $str = '')
{
	$iCount = count($arRef);
	if ($iCount > 2)
	{
		$arRef = RefSortByNumeric($arRef, '_callbackSortFundEst');
		$str .= '共'.strval($iCount).'项';
	}
	
	EchoTableParagraphBegin($arColumn, 'estimation', $str);
    foreach ($arRef as $ref)		_echoFundEstTableItem($ref, $bFair);
    EchoTableParagraphEnd();
}

function EchoFundArrayEstParagraph($arRef)
{
	$arColumn = _getFundEstTableColumn($arRef, $bFair);
	_echoFundEstParagraph($arColumn, $bFair, $arRef);
}

function EchoFundEstParagraph($ref)
{
	$arRef = array($ref);
	$arColumn = _getFundEstTableColumn($arRef, $bFair);
	
	$str = GetTableColumnNetValue().$ref->GetDate().'、';
	$str .= $arColumn[2]->GetDisplay().$ref->GetOfficialDate().'，最近'.GetCalibrationHistoryLink($ref->GetSymbol()).$ref->GetTimeNow().'。';
    if ($ref->GetRealtimeNav())
    {
    	$col = $bFair ? $arColumn[6] : $arColumn[4]; 
    	$strRealtimeEst = $col->GetDisplay();
    	$future_ref = $ref->GetFutureRef();
    	$future_etf_ref = $ref->future_etf_ref;
    	$est_ref = $ref->GetEstRef();
    
    	$strFutureSymbol = $future_ref->GetSymbol();
    	$str .= "期货{$strRealtimeEst}{$strFutureSymbol}关联程度按照100%估算";
    
    	if ($future_etf_ref && ($future_etf_ref != $est_ref))
    	{
    		$strEtfSymbol = $est_ref->GetSymbol();
    		$strFutureEtfSymbol = $future_etf_ref->GetSymbol();
    		$str .= '，'.GetYahooNavLink($strEtfSymbol).'和'.GetCalibrationHistoryLink($strFutureEtfSymbol, true).'关联程度按照100%估算';
    	}
    	$str .= '。';
    	
//    	if ($strFutureSymbol == 'hf_CL')		$str .= '<br />'.GetFontElement(STOCK_DISP_TEMPERROR);
    }
    
	_echoFundEstParagraph($arColumn, $bFair, $arRef, $str);
}

function EchoHoldingsEstParagraph($ref)
{
	$arRef = array($ref);
	$arColumn = _getFundEstTableColumn($arRef, $bFair);
	
	$nav_ref = $ref->GetNavRef();
	$str = GetTableColumnNetValue().$nav_ref->GetDate().', ';
	$str .= $arColumn[2]->GetDisplay().$ref->GetOfficialDate().', ';
	$str .= GetHoldingsLink($ref->GetSymbol()).'更新于'.$ref->GetHoldingsDate().'.';

	_echoFundEstParagraph($arColumn, $bFair, $arRef, $str);
}

?>
