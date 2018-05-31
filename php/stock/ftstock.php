<?php

/*
<div class="mod-tearsheet-overview__header">
<h1 class="mod-tearsheet-overview__header__name mod-tearsheet-overview__header__name--large">S&amp;P Oil &amp; Gas Exploration &amp; Producti</h1>
<div class="mod-tearsheet-overview__header__symbol"><span>SPSIOP:IOM</span></div>
<h1 class="mod-tearsheet-overview__header__name mod-tearsheet-overview__header__name--small">S&amp;P Oil &amp; Gas Exploration &amp; Producti</h1>
<div class="mod-ui-action-menu mod-ui-page-action-menu"><span class="mod-ui-hide-small-below mod-ui-action-menu__button-text">Actions</span>
<button class="o-buttons mod-ui-button mod-ui-button--icon mod-ui-button--bordered mod-ui-hide-small-below" data-mod-action="showMenu" type="button"><i class="o-ft-icons-icon o-ft-icons-icon--arrow-down"></i></button>
<button class="o-buttons mod-ui-button mod-ui-button--icon mod-ui-button--bordered mod-ui-action-menu__button__icon mod-ui-hide-medium-above" data-mod-action="showMenu" type="button"><i class="o-ft-icons-icon o-ft-icons-icon--more"></i></button>
<div class="mod-ui-overlay mod-ui-overlay--trans mod-ui-action-menu__menu" aria-hidden="true"><div class="mod-ui-overlay__content">
<ul><li class="mod-ui-action-menu__item mod-ui-action-menu__item" data-mod-action="add-to-watchlist"><i class="mod-icon mod-icon--ir-state-published"></i><span class="mod-ui-action-menu__item__text">Add to watchlist</span></li>
<li class="mod-ui-action-menu__item mod-ui-action-menu__item" data-mod-action="add-alert"><i class="mod-icon mod-icon--bell"></i><span class="mod-ui-action-menu__item__text">Add an alert</span></li></ul>
</div></div></div></div>
<div class="mod-tearsheet-overview__quote"><ul class="mod-tearsheet-overview__quote__bar">
<li><span class="mod-ui-data-list__label">Price (USD)</span><span class="mod-ui-data-list__value">6,019.43</span></li>
<li><span class="mod-ui-data-list__label">Today's Change</span><span class="mod-ui-data-list__value"><span class="mod-format--pos"><i class="o-ft-icons-icon o-ft-icons-icon--arrow-upwards"></i>89.40 / 1.51%</span></span></li>
<li><span class="mod-ui-data-list__label">Shares traded</span><span class="mod-ui-data-list__value">0.00</span></li>
<li><span class="mod-ui-data-list__label">1 Year change</span><span class="mod-ui-data-list__value"><span class="mod-format--pos"><i class="o-ft-icons-icon o-ft-icons-icon--arrow-upwards"></i>13.01%</span></span></li>
<li><span class="mod-ui-data-list__label">52 week range</span><span class="mod-ui-data-list__value">4,400.55 - 6,118.66</span></li></ul>
<div class="mod-disclaimer">Data delayed at least 10 minutes, as of Apr 30 2018 15:40 BST.</div>
*/

function _preg_match_ft_stock($str)
{
    $strBoundary = RegExpBoundary();
    $strAll = RegExpAll();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('<span class="mod-ui-data-list__value">', RegExpFmtNumber(), '</span>');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('<i class="o-ft-icons-icon o-ft-icons-icon--arrow-[^"]*"></i>', '[^<]*', '</span>');
    $strPattern .= $strAll;
    $strPattern .= RegExpParenthesis('<div class="mod-disclaimer">', '[^<]*', '</div>');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    if (RegExpDebug($arMatch, 'FT stock', 0) == 0)	return false;
    return $arMatch;
}

function FtStockGetUrl($sym)
{
	if ($sym->IsIndex())
	{
		if ($strFtSymbol = $sym->GetFtSymbol())
		{
			return 'https://markets.ft.com/data/indices/tearsheet/summary?s='.$strFtSymbol;
		}
	}
	return false;
}

function TestFtStock($strSymbol)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
    $sym = new StockSymbol($strSymbol);
    if (($strUrl = FtStockGetUrl($sym)) == false)	return false;
    $str = url_get_contents($strUrl);
//	DebugString($str);
	$strPrice = '';
	if ($arMatch = _preg_match_ft_stock($str))
	{
		foreach ($arMatch as $ar)
		{
			$strPrice .= str_replace(',', '', $ar[1]).' ';
			
			$strChange = str_replace(',', '', $ar[2]);
			$strChange = strstr($strChange, ' ', true);
			$strPrice .= $strChange.' ';
			
			$strTime = strstr($ar[3], 'as of ');
			$strTime = ltrim($strTime, 'as of ');
			$strTime = rtrim($strTime, '.');
			$ymd = new YMDTick(strtotime($strTime));
			$strPrice .= $ymd->GetYMD().' '.$ymd->GetHMS().' ';
		}
	}
	return $strPrice;
}

?>
