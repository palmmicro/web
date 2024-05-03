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
    return $ref->GetMarketSession()._textPriceVolume($ref);
}

function TextFromStockReference($ref)
{
    if ($ref->HasData() == false)        return false;

    $strSymbol = $ref->GetSymbol();
    $str = SqlGetStockName($strSymbol).BOT_EOL;
    
    global $acct;
    $str .= method_exists($acct, 'SetCallback') ? $strSymbol : $ref->GetStockLink();  
    $str .= BOT_EOL;
    $str .= STOCK_DISP_PRICE._textPriceVolume($ref);
    $str .= STOCK_DISP_CHANGE.':'.$ref->GetPercentageText().BOT_EOL;
    if ($ref->strOpen)			$str .= STOCK_DISP_OPEN.':'.rtrim0($ref->strOpen).BOT_EOL;
    if ($ref->strHigh)			$str .= STOCK_DISP_HIGH.':'.rtrim0($ref->strHigh).BOT_EOL;
    if ($ref->strLow)			$str .= STOCK_DISP_LOW.':'.rtrim0($ref->strLow).BOT_EOL;
    if ($ref->extended_ref)	$str .= TextFromExtendedTradingReferencce($ref->extended_ref);
    return $str;
}

function TextPairRatio($ref, $strName, $strPairName, $strRatio)
{
	$str = '';
   	if ($ref)
    {
    	$str .= BOT_EOL.$strName.STOCK_DISP_SYMBOL.':'.$ref->GetSymbol();
    	$pair_ref = $ref->GetPairRef();
    	$str .= BOT_EOL.$strPairName.STOCK_DISP_SYMBOL.':'.$pair_ref->GetSymbol();
   		$str .= BOT_EOL.$strRatio.STOCK_DISP_RATIO.':'.strval_round($ref->GetPriceRatio()).BOT_EOL;
   	}
   	return $str;
}

function _textPremium($ref, $strEst)
{
    if ($ref->HasData())
    {
        return STOCK_DISP_PREMIUM.':'.$ref->GetPercentageText($strEst);
    }
    return '';
}

function _textEstPremium($ref, $strEst)
{
    $str = STOCK_DISP_EST.':'.strval_round(floatval($strEst), $ref->GetPrecision());	//	$ref->GetPriceText($strEst);
    $str .= ' '._textPremium($ref, $strEst);
    return $str;
}

function _textEstNav($fund, $ref)
{
	$str = '';
	if ($strNav = $fund->GetOfficialNav())		$str .= STOCK_DISP_OFFICIAL._textEstPremium($ref, $strNav).' '.$fund->GetOfficialDate().BOT_EOL;
	if ($strNav = $fund->GetFairNav())			$str .= STOCK_DISP_FAIR._textEstPremium($ref, $strNav).BOT_EOL;
    if (method_exists($fund, 'GetRealtimeNav'))
    {
    	if ($strNav = $fund->GetRealtimeNav())	$str .= STOCK_DISP_REALTIME._textEstPremium($ref, $strNav).BOT_EOL;
    }
	return $str;
}

function TextFromFundReference($ref)
{
    if ($ref->HasData() == false)                return false;

    $strSymbol = $ref->GetSymbol();
    $strName = SqlGetStockName($strSymbol).BOT_EOL.$strSymbol.BOT_EOL;
	if (method_exists($ref, 'GetStockRef'))
	{
		$stock_ref = $ref->GetStockRef();
		$strNetValue = $ref->GetPrice();
		$strDate = $ref->GetDate();
		$strPercentage = $ref->GetPercentageText();
	}
	else
	{
		$stock_ref = $ref;
		$nav_ref = $ref->GetNavRef();
		$strNetValue = $nav_ref->GetPrice();
		$strDate = $nav_ref->GetDate();
		$strPercentage = $nav_ref->GetPercentageText();
	}
	
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
    
    $str .= STOCK_DISP_NAV.':'.$strNetValue.' '.$strDate.BOT_EOL;
    $str .= STOCK_DISP_NAV.STOCK_DISP_CHANGE.':'.$strPercentage.BOT_EOL;
    if ($stock_ref)
    {
    	if ($stock_ref->GetDate() == $strDate)	$str .= _textPremium($stock_ref, $strNetValue).BOT_EOL;
    	$str .= _textEstNav($ref, $stock_ref);
    }
    return $str;
}

?>
