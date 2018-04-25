<?php
require_once('stocktable.php');

function _echoCalibrationItem($strStockId, $strPairId, $history, $bReadOnly, $bChinese)
{
   	$strDate = $history['date'];
    $strPrice = SqlGetNetValueByDate($strStockId, $strDate);
    $strPairPrice = SqlGetNetValueByDate($strPairId, $strDate);
    if ($bReadOnly == false)
    {
    	$strDate = GetOnClickLink('/php/_submitdelete.php?calibrationid='.$history['id'], '确认删除'.$history['date'].'校准记录?', $history['date']);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPairPrice</td>
        <td class=c1>{$history['factor']}</td>
        <td class=c1>$strDate</td>
    </tr>
END;
}

function _echoCalibrationData($strSymbol, $iStart, $iNum, $bChinese)
{
    if (AcctIsAdmin())
    {
        $bReadOnly = false;
    }
    else
    {
        $bReadOnly = true;
    }
    
	$strStockId = SqlGetStockId($strSymbol);
    $record = SqlGetStockPair(TABLE_ETF_PAIR, $strStockId);
    $strEtfPairId = $record['id'];
    if ($result = SqlGetCalibration($strEtfPairId, $iStart, $iNum)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationItem($strStockId, $record['pair_id'], $history, $bReadOnly, $bChinese);
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationFullParagraph($strSymbol, $iStart, $iNum, $bChinese)
{
	$strPair = SqlGetEtfPair($strSymbol);
	$strPrice = GetReferenceTablePrice($bChinese);
    if ($bChinese)  $arColumn = array($strSymbol.$strPrice,     $strPair.$strPrice,     '校准值', '日期');
    else              $arColumn = array($strSymbol.' '.$strPrice, $strPair.' '.$strPrice, 'Factor', 'Date');
    
	$str = '';    
    if (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))
    {
        $str .= ' '.GetCalibrationLink($strSymbol, $bChinese);
    }
    
    EchoParagraphBegin($str);
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=590 border=1 class="text" id="calibration">
    <tr>
        <td class=c1 width=170 align=center>{$arColumn[0]}</td>
        <td class=c1 width=170 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=150 align=center>{$arColumn[3]}</td>
    </tr>
END;

    _echoCalibrationData($strSymbol, $iStart, $iNum, $bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
}

function EchoCalibrationParagraph($strSymbol, $bChinese)
{
	EchoCalibrationFullParagraph($strSymbol, 0, TABLE_COMMON_DISPLAY, $bChinese);
}

?>
