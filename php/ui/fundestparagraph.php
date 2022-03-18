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
    
    RefEchoTableColumn($ref, $ar);
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
				  new TableColumnNav(),
				  new TableColumnOfficalEst(),
				  $premium_col);
	
	$bFair = false;
    foreach ($arRef as $ref)
    {
        if ($ref->GetFairNav())
        {
        	$bFair = true;
        	$ar[] = new TableColumnFairEst();
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
    			$ar[] = new TableColumnRealtimeEst();
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

function _getFundPositionStr($official_est_col, $strSymbol, $ref)
{
	$str = '、'.$official_est_col->GetDisplay().$ref->GetOfficialDate();
	$fPosition = FundGetPosition($ref);
	if ($fPosition < 1.0)		$str .= '，'.GetFundPositionLink($strSymbol).'值使用'.strval($fPosition);
	return $str;
}

function EchoFundEstParagraph($ref)
{
	$arRef = array($ref);
	$arColumn = _getFundEstTableColumn($arRef, $bFair);
	
	$strSymbol = $ref->GetSymbol();
	$str = GetTableColumnNav().$ref->GetDate();
	$str .= _getFundPositionStr($arColumn[2], $strSymbol, $ref);
	$str .= '，最近'.GetCalibrationHistoryLink($strSymbol).$ref->GetTimeNow().'。';
    if ($ref->GetRealtimeNav())
    {
    	$col = $bFair ? $arColumn[6] : $arColumn[4]; 
    	$est_ref = $ref->GetEstRef();
    	$future_ref = $ref->GetFutureRef();
    	$future_etf_ref = $ref->future_etf_ref;
    
    	$str .= '期货'.$col->GetDisplay().$future_ref->GetMyStockLink().'关联程度按照100%估算';
    	if ($future_etf_ref && ($future_etf_ref != $est_ref))		$str .= '，'.$est_ref->GetMyStockLink().'和'.GetCalibrationHistoryLink($future_etf_ref->GetSymbol(), true).'关联程度按照100%估算';
    	$str .= '。';
    }
    
	_echoFundEstParagraph($arColumn, $bFair, $arRef, $str);
}

function EchoHoldingsEstParagraph($ref)
{
	$arRef = array($ref);
	$arColumn = _getFundEstTableColumn($arRef, $bFair);
	
	$strSymbol = $ref->GetSymbol();
	$nav_ref = $ref->GetNavRef();
	$str = GetTableColumnNav().$nav_ref->GetDate();
	$str .= _getFundPositionStr($arColumn[2], $strSymbol, $ref);
	$str .= '，'.GetHoldingsLink($strSymbol).'更新于'.$ref->GetHoldingsDate().'。';

	_echoFundEstParagraph($arColumn, $bFair, $arRef, $str);
}

?>
