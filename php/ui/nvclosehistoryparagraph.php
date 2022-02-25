<?php
require_once('stocktable.php');

function _echoNvCloseItem($csv, $his_sql, $shares_sql, $arHistory, $arFundNav, $ref, $strStockId, $bAdmin)
{
	$strClose = $arHistory['close'];
	$strDate = $arHistory['date'];
	if (($strClosePrev = $his_sql->GetClosePrev($strStockId, $strDate)) === false)		return;
	
	$strNav = rtrim0($arFundNav['close']);
   	if ($csv)		$csv->Write($strDate, $ref->GetPercentageString($strClosePrev, $strClose), $ref->GetPercentageString($strNav, $strClose), $strNav);

   	$ar = array($strDate, $ref->GetPriceDisplay($strClose, $strNav));
   	$ar[] = $bAdmin ? GetOnClickLink('/php/_submitdelete.php?'.TABLE_NETVALUE_HISTORY.'='.$arFundNav['id'], '确认删除净值记录'.$strNav.'？', $strNav) : $strNav;
	$ar[] = $ref->GetPercentageDisplay($strNav, $strClose);
   	$ar[] = $ref->GetPercentageDisplay($strClosePrev, $strClose);
    if ($strShares = $shares_sql->GetClose($strStockId, $strDate))
    {
    	$ar[] = rtrim0($strShares);
    	$fVolume = floatval($his_sql->GetVolume($strStockId, $strDate));
    	$ar[] = strval_round(100.0 * $fVolume / (floatval($strShares) * 10000.0), 2);
    }
    
    EchoTableColumn($ar);
}

function _echoNvCloseData($his_sql, $ref, $strStockId, $csv, $iStart, $iNum, $bAdmin)
{
	$bSameDayNav = UseSameDayNav($ref);
	$nav_sql = GetNavHistorySql();
	$shares_sql = new SharesHistorySql();
    if ($result = $his_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($arHistory = mysql_fetch_assoc($result)) 
        {
       		$strDate = $bSameDayNav ? $arHistory['date'] : $his_sql->GetDatePrev($strStockId, $arHistory['date']);
        	if ($arFundNav = $nav_sql->GetRecord($strStockId, $strDate))	_echoNvCloseItem($csv, $his_sql, $shares_sql, $arHistory, $arFundNav, $ref, $strStockId, $bAdmin);
        }
        @mysql_free_result($result);
    }
}

function EchoNvCloseHistoryParagraph($ref, $str = false, $csv = false, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
    if ($ref->CountNav() == 0)	return;

	$strStockId = $ref->GetStockId();
    $strSymbol = $ref->GetSymbol();
    $his_sql = GetStockHistorySql();
   	$strMenuLink = IsTableCommonDisplay($iStart, $iNum) ? '' : StockGetMenuLink($strSymbol, $his_sql->Count($strStockId), $iStart, $iNum);
   	if ($str == false)	$str = GetNvCloseHistoryLink($strSymbol);

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnPrice(),
								   new TableColumnNetValue(),
								   new TableColumnPremium('y'),
								   new TableColumnChange('x'),
								   new TableColumnShare(),
								   new TableColumnTradingPercentage()
								   ), $strSymbol.NVCLOSE_HISTORY_PAGE, $str.' '.$strMenuLink);

    _echoNvCloseData($his_sql, $ref, $strStockId, $csv, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strMenuLink);
}

?>
