<?php
require_once('stocktable.php');

function _echoCalibrationItem($ref, $strNetValue, $strDate, $bAdmin)
{
	$pair_nav_ref = $ref->GetPairNavRef();
    if ($strPairNetValue = PairNavGetClose($pair_nav_ref, $strDate))
    {
    	$ar = array($strDate);
   		$ar[] = $ref->GetPriceDisplay($strNetValue);

   		$pair_ref = $ref->GetPairRef();
   		$ar[] = $strPairPrice = $pair_ref->GetPriceDisplay($strPairNetValue);
    
   		$ar[] = strval_round($ref->GetFactor($strPairNetValue, $strNetValue));
   		EchoTableColumn($ar);
    }
}

function _echoCalibrationData($ref, $strStockId, $nav_sql, $iStart, $iNum, $bAdmin)
{
    if ($result = $nav_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		_echoCalibrationItem($ref, $strNetValue, $record['date'], $bAdmin);
        	}
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationParagraph($ref, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
	$strSymbol = $ref->GetSymbol();
    $ref = new EtfReference($strSymbol);
    if ($ref->GetPairNavRef() == false)	return;
    
	$nav_sql = GetNavHistorySql();
	$strStockId = $ref->GetStockId();
    
	if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str = GetCalibrationLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$str = GetEtfListLink();
    	$strNavLink = StockGetNavLink($strSymbol, $nav_sql->Count($strStockId), $iStart, $iNum);
    }
    
    if ($bAdmin)
    {
    	$str .= ' '.GetInternalLink('/php/_submitoperation.php?calibration='.$strSymbol, '手工校准');
    }
    $str .= ' '.$strNavLink;

	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnNetValue(),
								   new TableColumnNetValue(SqlGetEtfPair($strSymbol)),
								   new TableColumnCalibration()
								   ), $strSymbol.TABLE_CALIBRATION, $str);

    _echoCalibrationData($ref, $strStockId, $nav_sql, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

?>
