<?php
require_once('stocktable.php');

function _echoCalibrationItem($ref, $sql, $strNetValue, $strDate, $bAdmin)
{
	$pair_nv_ref = $ref->GetPairNvRef();
    if ($strPairNetValue = PairNvGetClose($pair_nv_ref, GetClose($strDate))
    {
    	$ar = array($strDate);
   		$ar[] = $ref->GetPriceDisplay($strNetValue);

   		$pair_ref = $ref->GetPairRef();
   		$ar[] = $strPairPrice = $pair_ref->GetPriceDisplay($strPairNetValue);
    
   		$ar[] = strval_round($ref->GetFactor($strPairNetValue, $strNetValue));
   		EchoTableColumn($ar);
    }
}

function _echoCalibrationData($ref, $sql, $iStart, $iNum, $bAdmin)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		_echoCalibrationItem($ref, $sql, $strNetValue, $record['date'], $bAdmin);
        	}
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationParagraph($ref, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
	$strSymbol = $ref->GetSymbol();
    
    $ref = new EtfReference($strSymbol);
    if ($ref->GetPairNvRef() == false)	return;
    
    $sql = $ref->nv_ref->sql;
    
	if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str = GetCalibrationLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$str = GetEtfListLink();
    	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
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
								   ), $strSymbol.'calibration', $str);

    _echoCalibrationData($ref, $sql, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

?>
