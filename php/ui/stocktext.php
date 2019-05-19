<?php
require_once('stockdisp.php');

// Text display UI

// ****************************** MyStockReference class functions *******************************************************

function _textVolume($strVolume)
{
    if (intval($strVolume) > 0)
    {
        $str = '成交量:'.$strVolume.'股'.WX_EOL;
    }
    else
    {
        $str = '';
    }
    return $str;
}

function TextFromExtendedTradingReferencce($ref)
{
    $str = RefGetDescription($ref).':'.$ref->GetPrice().' '.$ref->strDate.' '.GetTimeHM($ref->strTime).WX_EOL;
    if ($ref->strVolume)	$str .= _textVolume($ref->strVolume);
    return $str;
}

function TextFromStockReference($ref)
{
    if ($ref->HasData() == false)        return false;

    $str = RefGetDescription($ref).WX_EOL;
    $str .= $ref->GetExternalLink().WX_EOL;
    $str .= STOCK_DISP_PRICE.':'.$ref->GetPrice().' '.$ref->strDate.' '.GetTimeHM($ref->strTime).WX_EOL;
    $str .= STOCK_DISP_CHANGE.':'.$ref->GetPercentageText($ref->GetPrevPrice()).WX_EOL;
    if ($ref->strOpen)		$str .= '开盘价:'.rtrim0($ref->strOpen).WX_EOL;
    if ($ref->strHigh)		$str .= '最高:'.rtrim0($ref->strHigh).WX_EOL;
    if ($ref->strLow)		$str .= '最低:'.rtrim0($ref->strLow).WX_EOL;
    if ($ref->strVolume)	$str .= _textVolume($ref->strVolume);
    
    if ($ref->extended_ref)
    {
        $str .= TextFromExtendedTradingReferencce($ref->extended_ref);
    }
    
    return $str;
}

function TextFromAhReference($ref, $hshare_ref)
{
	$str = TextFromStockReference($ref);
	$str .= 'H股代码:'.RefGetMyStockLink($hshare_ref).WX_EOL;
	if ($hshare_ref->a_ref)		$str .= 'A股代码:'.RefGetMyStockLink($hshare_ref->a_ref).WX_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADR代码:'.RefGetMyStockLink($hshare_ref->adr_ref).WX_EOL;
	if ($hshare_ref->a_ref)		$str .= 'AH比价:'.strval_round($hshare_ref->GetAhPriceRatio()).WX_EOL;
	if ($hshare_ref->adr_ref)	$str .= 'ADRH比价:'.strval_round($hshare_ref->GetAdrhPriceRatio()).WX_EOL;
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

    $strName = RefGetDescription($ref).WX_EOL.$ref->GetStockSymbol().WX_EOL;
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
    
    $str .= STOCK_DISP_NETVALUE.':'.$ref->GetPrice().' '.$ref->strDate.WX_EOL;
    if ($ref->fOfficialNetValue)
    {
        $str .= STOCK_DISP_OFFICIAL._textPremium($stock_ref, $ref->fOfficialNetValue).' '.$ref->strOfficialDate.WX_EOL;
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
