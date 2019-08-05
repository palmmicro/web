<?php
require_once('stocktable.php');

function _echoCalibrationItem($ref, $record, $bAdmin)
{
   	$strDate = $record['date'];
    $strPrice = $ref->GetPriceDisplay($ref->nv_ref->sql->GetClose($strDate));
    
    $pair_ref = $ref->GetPairRef();
    $strPairPrice = $pair_ref->GetPriceDisplay($ref->pair_nv_ref->sql->GetClose($strDate));
    
    $strClose = $record['close'];
    if ($bAdmin)
    {
    	$strDate = GetOnClickLink('/php/_submitdelete.php?'.TABLE_ETF_CALIBRATION.'='.$record['id'], '确认删除'.$strDate.'校准记录'.$strClose.'?', $strDate);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strPrice</td>
        <td class=c1>$strPairPrice</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strDate</td>
    </tr>
END;
}

function _echoCalibrationData($ref, $iStart, $iNum, $bAdmin)
{
    if ($result = $ref->sql->GetAll($iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoCalibrationItem($ref, $record, $bAdmin);
        }
        @mysql_free_result($result);
    }
}

function EchoCalibrationParagraph($ref, $iStart = 0, $iNum = TABLE_COMMON_DISPLAY, $bAdmin = false)
{
	$strSymbol = $ref->GetStockSymbol();
	$strPair = SqlGetEtfPair($strSymbol);
	$strNetValue = GetTableColumnNetValue();
    $arColumn = array($strSymbol.$strNetValue, $strPair.$strNetValue, '校准值', GetTableColumnDate());
    
    $ref = new EtfReference($strSymbol);
    if (IsTableCommonDisplay($iStart, $iNum))
    {
        $str = GetCalibrationLink($strSymbol);
        $strNavLink = '';
    }
    else
    {
    	$str = GetEtfListLink();
    	$iTotal = $ref->sql->Count();
    	$strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum);
    }
    
    if ($bAdmin)
    {
    	$str .= ' '.GetInternalLink('/php/_submitoperation.php?calibration='.$strSymbol, '手工校准');
    }
    
    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=590 border=1 class="text" id="calibration">
    <tr>
        <td class=c1 width=170 align=center>{$arColumn[0]}</td>
        <td class=c1 width=170 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=150 align=center>{$arColumn[3]}</td>
    </tr>
END;

    _echoCalibrationData($ref, $iStart, $iNum, $bAdmin);
    EchoTableParagraphEnd($strNavLink);
}

?>
