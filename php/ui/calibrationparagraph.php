<?php
require_once('stocktable.php');

function _echoCalibrationItem($ref, $arHistory, $bTest)
{
   	$strDate = $arHistory['date'];
    $strPrice = $ref->GetPriceDisplay($ref->nv_ref->sql->GetClose($strDate), false);
    $strPairPrice = $ref->pair_ref->GetPriceDisplay($ref->pair_nv_ref->sql->GetClose($strDate), false);
    
    $strClose = $arHistory['close'];
    if ($bTest)
    {
    	$strDate = GetOnClickLink('/php/_submitdelete.php?'.TABLE_ETF_CALIBRATION.'='.$arHistory['id'], '确认删除'.$strDate.'校准记录'.$strClose.'?', $strDate);
    }
    
 	$strClose = GetTableColumnFloatDisplay($strClose);
    echo <<<END
    <tr>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPairPrice</td>
        $strClose
        <td class=c1>$strDate</td>
    </tr>
END;
}

function _echoCalibrationData($ref, $iStart, $iNum, $bTest)
{
    if ($result = $ref->sql->GetAll($iStart, $iNum)) 
    {
        while ($arHistory = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationItem($ref, $arHistory, $bTest);
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationParagraph($strSymbol, $bChinese, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY)
{
	$strSymbolLink = GetMyStockLink($strSymbol);
	$strPair = SqlGetEtfPair($strSymbol);
	$strPairLink = GetMyStockLink($strPair);
	$arFundEst = GetFundEstTableColumn($bChinese);
	$strNetValue = $arFundEst[7];
    if ($bChinese)  $arColumn = array($strSymbolLink.$strNetValue,     $strPairLink.$strNetValue,     '校准值', '日期');
    else              $arColumn = array($strSymbolLink.' '.$strNetValue, $strPairLink.' '.$strNetValue, 'Factor', 'Date');
    
    $ref = new EtfReference($strSymbol);
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str = GetCalibrationLink($strSymbol, $bChinese);
        $strNavLink = '';
    }
    else
    {
    	$str = GetEtfListLink($bChinese);
    	$iTotal = $ref->sql->Count();
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
    	$str .= ' '.$strNavLink;
    }
    
    if ($bTest = AcctIsAdmin())
    {
    	$str .= ' '.GetInternalLink('/php/_submitoperation.php?calibration='.$strSymbol, '手工校准');
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

    _echoCalibrationData($ref, $iStart, $iNum, $bTest);
    EchoTableParagraphEnd($strNavLink);
}

?>
