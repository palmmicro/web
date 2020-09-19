<?php
require_once('stockdisp.php');

// Text display UI

// ****************************** MyStockReference class functions *******************************************************
function _textPriceVolume($ref)
{
    $str = ':'.$ref->GetPrice().' '.$ref->GetDate().' '.$ref->GetTimeHM().WX_EOL;
    $strVolume = $ref->GetVolume();
    if (intval($strVolume) > 0)
    {
        $str .= STOCK_DISP_QUANTITY.':'.$strVolume.'股'.WX_EOL;
    }
    return $str;
}

function TextFromExtendedTradingReferencce($ref)
{
    return RefGetDescription($ref)._textPriceVolume($ref);
}

function TextFromStockReference($ref)
{
    if ($ref->HasData() == false)        return false;

    $str = RefGetDescription($ref).WX_EOL;
    $str .= $ref->GetStockLink().WX_EOL;
    $str .= STOCK_DISP_PRICE._textPriceVolume($ref);
    $str .= STOCK_DISP_CHANGE.':'.$ref->GetPercentageText().WX_EOL;
    if ($ref->strOpen)			$str .= STOCK_DISP_OPEN.':'.rtrim0($ref->strOpen).WX_EOL;
    if ($ref->strHigh)			$str .= STOCK_DISP_HIGH.':'.rtrim0($ref->strHigh).WX_EOL;
    if ($ref->strLow)			$str .= STOCK_DISP_LOW.':'.rtrim0($ref->strLow).WX_EOL;
    if ($ref->extended_ref)	$str .= TextFromExtendedTradingReferencce($ref->extended_ref);
    return $str;
}

function TextFromAhReference($hshare_ref)
{
	$str = 'H股代码:'.RefGetMyStockLink($hshare_ref).WX_EOL;
	if ($hshare_ref->a_ref)		$str .= 'A股代码:'.RefGetMyStockLink($hshare_ref->a_ref).WX_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADR代码:'.RefGetMyStockLink($hshare_ref->adr_ref).WX_EOL;
	if ($hshare_ref->a_ref)		$str .= 'AH'.STOCK_DISP_RATIO.':'.strval_round($hshare_ref->GetAhPriceRatio()).WX_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADRH'.STOCK_DISP_RATIO.':'.strval_round($hshare_ref->GetAdrhPriceRatio()).WX_EOL;
	return $str;
}

function TextFromAbReference($ab_ref, $bStockA = true)
{
	if ($bStockA)
	{
		$str = 'B股代码:'.RefGetMyStockLink($ab_ref->GetPairRef()).WX_EOL;
	}
	else
	{
		$str = 'A股代码:'.RefGetMyStockLink($ab_ref).WX_EOL;
	}
	return $str;
}

function _textPremium($stock_ref, $fEst)
{
    $str = STOCK_DISP_EST.':'.$stock_ref->GetPriceText($fEst);
    if ($stock_ref->HasData())
    {
        $str .= ' '.STOCK_DISP_PREMIUM.':'.$stock_ref->GetPercentageText(strval($fEst));
    }
    return $str;
}

function TextFromFundReference($ref)
{
    if ($ref->HasData() == false)                return false;

    $strName = RefGetDescription($ref).WX_EOL.$ref->GetSymbol().WX_EOL;
    $stock_ref = $ref->stock_ref;
    if ($stock_ref)
    {
        if (($str = TextFromStockReference($stock_ref)) == false)
        {
            $str = $strName;
        }
    }
    else
    {
        $str = $strName;
    }
    
    $str .= STOCK_DISP_NETVALUE.':'.$ref->GetPrice().' '.$ref->GetDate().WX_EOL;
    $str .= STOCK_DISP_NETVALUE.STOCK_DISP_CHANGE.':'.$ref->GetPercentageText().WX_EOL;
    if ($ref->fOfficialNetValue)
    {
        $str .= STOCK_DISP_OFFICIAL._textPremium($stock_ref, $ref->fOfficialNetValue).' '.$ref->GetOfficialDate().WX_EOL;
    }
    if ($ref->fFairNetValue)
    {
        $str .= STOCK_DISP_FAIR._textPremium($stock_ref, $ref->fFairNetValue).WX_EOL;
    }
    if ($ref->fRealtimeNetValue)
    {
        $str .= STOCK_DISP_REALTIME._textPremium($stock_ref, $ref->fRealtimeNetValue).WX_EOL;
    }
    return $str;
}

?>
