<?php
require_once('stocktable.php');

function _echoCalibrationItem($sql, $history, $bReadOnly, $bChinese)
{
   	$strDate = $history['date'];
    $strPrice = $sql->fund_sql->GetCloseString($strDate);
    $strPairPrice = $sql->pair_fund_sql->GetCloseString($strDate);
    if ($bReadOnly == false)
    {
    	$strDate = GetOnClickLink('/php/_submitdelete.php?etfcalibrationid='.$history['id'], '确认删除'.$history['date'].'校准记录?', $history['date']);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPairPrice</td>
        <td class=c1>{$history['close']}</td>
        <td class=c1>$strDate</td>
    </tr>
END;
}

function _echoCalibrationData($sql, $strSymbol, $strStockId, $iStart, $iNum, $bChinese)
{
    if (AcctIsAdmin())
    {
        $bReadOnly = false;
    }
    else
    {
        $bReadOnly = true;
    }
    
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationItem($sql, $history, $bReadOnly, $bChinese);
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationParagraph($strSymbol, $strStockId, $bChinese, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$strSymbolLink = GetMyStockLink($strSymbol, $bChinese);
	$strPair = SqlGetEtfPair($strSymbol);
	$strPairLink = GetMyStockLink($strPair, $bChinese);
	$strPrice = GetReferenceTablePrice($bChinese);
    if ($bChinese)  $arColumn = array($strSymbolLink.$strPrice,     $strPairLink.$strPrice,     '校准值', '日期');
    else              $arColumn = array($strSymbolLink.' '.$strPrice, $strPairLink.' '.$strPrice, 'Factor', 'Date');
    
    $sql = new EtfCalibrationSql($strStockId);
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str = GetCalibrationLink($strSymbol, $bChinese);
        $strNavLink = '';
    }
    else
    {
    	$iTotal = $sql->Count();
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    	$str = $strNavLink;
    }
    
    echo <<<END
    <p>$str
    <TABLE borderColor=#cccccc cellSpacing=0 width=590 border=1 class="text" id="calibration">
    <tr>
        <td class=c1 width=170 align=center>{$arColumn[0]}</td>
        <td class=c1 width=170 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=150 align=center>{$arColumn[3]}</td>
    </tr>
END;

    _echoCalibrationData($sql, $strSymbol, $strStockId, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);
}

?>
