<?php
require_once('stockdisp.php');

// Text display UI

// ****************************** MyStockReference class functions *******************************************************
function _textPriceVolume($ref)
{
    $str = ':'.$ref->GetPrice().' '.$ref->GetDate().' '.$ref->GetTimeHM().BOT_EOL;
    $strVolume = $ref->GetVolume();
    if (intval($strVolume) > 0)
    {
        $str .= STOCK_DISP_QUANTITY.':'.$strVolume.'股'.BOT_EOL;
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

    $str = RefGetDescription($ref).BOT_EOL;
    $str .= $ref->GetStockLink().BOT_EOL;
    $str .= STOCK_DISP_PRICE._textPriceVolume($ref);
    $str .= STOCK_DISP_CHANGE.':'.$ref->GetPercentageText().BOT_EOL;
    if ($ref->strOpen)			$str .= STOCK_DISP_OPEN.':'.rtrim0($ref->strOpen).BOT_EOL;
    if ($ref->strHigh)			$str .= STOCK_DISP_HIGH.':'.rtrim0($ref->strHigh).BOT_EOL;
    if ($ref->strLow)			$str .= STOCK_DISP_LOW.':'.rtrim0($ref->strLow).BOT_EOL;
    if ($ref->extended_ref)	$str .= TextFromExtendedTradingReferencce($ref->extended_ref);
    return $str;
}

function TextFromAhReference($hshare_ref)
{
	$str = 'H股代码:'.RefGetMyStockLink($hshare_ref).BOT_EOL;
	if ($hshare_ref->a_ref)		$str .= 'A股代码:'.RefGetMyStockLink($hshare_ref->a_ref).BOT_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADR代码:'.RefGetMyStockLink($hshare_ref->adr_ref).BOT_EOL;
	if ($hshare_ref->a_ref)		$str .= 'AH'.STOCK_DISP_RATIO.':'.strval_round($hshare_ref->GetAhPriceRatio()).BOT_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADRH'.STOCK_DISP_RATIO.':'.strval_round($hshare_ref->GetAdrhPriceRatio()).BOT_EOL;
	return $str;
}

function TextFromAbReference($ab_ref, $bStockA = true)
{
	if ($bStockA)
	{
		$str = 'B股代码:'.RefGetMyStockLink($ab_ref->GetPairRef()).BOT_EOL;
	}
	else
	{
		$str = 'A股代码:'.RefGetMyStockLink($ab_ref).BOT_EOL;
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

    $strName = RefGetDescription($ref).BOT_EOL.$ref->GetSymbol().BOT_EOL;
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
    
    $str .= STOCK_DISP_NETVALUE.':'.$ref->GetPrice().' '.$ref->GetDate().BOT_EOL;
    $str .= STOCK_DISP_NETVALUE.STOCK_DISP_CHANGE.':'.$ref->GetPercentageText().BOT_EOL;
    if ($ref->fOfficialNetValue)
    {
        $str .= STOCK_DISP_OFFICIAL._textPremium($stock_ref, $ref->fOfficialNetValue).' '.$ref->GetOfficialDate().BOT_EOL;
    }
    if ($ref->fFairNetValue)
    {
        $str .= STOCK_DISP_FAIR._textPremium($stock_ref, $ref->fFairNetValue).BOT_EOL;
    }
    if ($ref->fRealtimeNetValue)
    {
        $str .= STOCK_DISP_REALTIME._textPremium($stock_ref, $ref->fRealtimeNetValue).BOT_EOL;
    }
    return $str;
}

?>
