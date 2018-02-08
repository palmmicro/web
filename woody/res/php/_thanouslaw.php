<?php
require_once('_stock.php');

// ****************************** PriceCompare Class *******************************************************

class PriceCompare
{
    var $iDays;
    
    var $iHigher;
    var $iUnchanged;
    var $iLower;

    // constructor 
    function PriceCompare() 
    {
        $this->iDays = 0;
        
        $this->iHigher = 0;
        $this->iUnchanged = 0;
        $this->iLower = 0;
    }
    
    function AddCompare($arClose)
    {
        $this->iDays ++;
        
        list($strClose, $strPrevClose) = $arClose;
        $fClose = floatval($strClose);
        $fPrevClose = floatval($strPrevClose);
            
        if (($fClose - MIN_FLOAT_VAL) > $fPrevClose)          $this->iHigher ++;
        else if (($fClose + MIN_FLOAT_VAL) < $fPrevClose)    $this->iLower ++;        
        else                                                      $this->iUnchanged ++;
    }
}

// ****************************** LOF Prediction Paragraph *******************************************************

function _getNetValueLink($strSymbol, $bChinese)
{
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    $strNetValue = UrlBuildPhpLink(STOCK_PATH.'netvaluehistory', 'symbol='.$strSymbol, '净值历史', 'Net Value History', $bChinese);
    return $strGroupLink.$strNetValue;
}

function _echoLofPredictionItem($str, $price_compare)
{
    $strDays = strval($price_compare->iDays);
    $strHigher = strval($price_compare->iHigher);
    $strUnchanged = strval($price_compare->iUnchanged);
    $strLower = strval($price_compare->iLower);
    
    echo <<<END
    <tr>
        <td class=c1>$str</td>
        <td class=c1>$strDays</td>
        <td class=c1>$strHigher</td>
        <td class=c1>$strUnchanged</td>
        <td class=c1>$strLower</td>
    </tr>
END;
}

define ('MAX_PREDICTION_DAYS', 100);

function _echoLofPredictionTableBegin($lof_ref, $etf_his, $bChinese)
{
    $strLofSymbol = $lof_ref->GetStockSymbol();
    $strEtfSymbol = $etf_his->GetStockSymbol();
    if ($bChinese)     
    {
        $arColumn = array($strLofSymbol.'交易', '天数', $strEtfSymbol.'涨', $strEtfSymbol.'不变', $strEtfSymbol.'跌');
    }
    else
    {
        $arColumn = array($strLofSymbol.' Trading', 'Days', $strEtfSymbol.' Higher', $strEtfSymbol.' Unchanged', $strEtfSymbol.' Lower');
    }

    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=570 border=1 class="text" id="prediction">
    <tr>
        <td class=c1 width=150 align=center>{$arColumn[0]}</td>
        <td class=c1 width=60 align=center>{$arColumn[1]}</td>
        <td class=c1 width=120 align=center>{$arColumn[2]}</td>
        <td class=c1 width=120 align=center>{$arColumn[3]}</td>
        <td class=c1 width=120 align=center>{$arColumn[4]}</td>
    </tr>
END;
}

function _echoLofPredictionParagraph($lof_ref, $etf_his, $bChinese)
{
    $arColumn = _GetHistoryTableColumnArray($etf_his, $bChinese);
    
    $netvalue_higher = new PriceCompare();
    $netvalue_same = new PriceCompare();
    $netvalue_lower = new PriceCompare();
    
    $strSymbol = $lof_ref->GetStockSymbol();
    $strStockId = $lof_ref->GetStockId();
    
    EchoParagraphBegin(_getNetValueLink($strSymbol, $bChinese));
    if ($result = SqlGetFundHistory($strStockId, 0, MAX_PREDICTION_DAYS)) 
    {
        _EchoHistoryTableBegin($arColumn);
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strDate = GetNextTradingDayYMD($record['date']);
            if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
            {
                $arEtfClose = $etf_his->GetDailyCloseByDate($strDate);
                if ($arEtfClose)
                {
                    $fNetValue = floatval($record['netvalue']);
                    $fClose = floatval($history['close']);
                    if (($fNetValue - MIN_FLOAT_VAL) > $fClose)          $netvalue_higher->AddCompare($arEtfClose);
                    else if (($fNetValue + MIN_FLOAT_VAL) < $fClose)     $netvalue_lower->AddCompare($arEtfClose);        
                    else                                                     $netvalue_same->AddCompare($arEtfClose);
                    
                    _echoHistoryTableItem($lof_ref, $history, $record, $arEtfClose);
                }
            }
        }
        @mysql_free_result($result);
        EchoTableEnd();
    }

    EchoNewLine();
    _echoLofPredictionTableBegin($lof_ref, $etf_his, $bChinese);
    _echoLofPredictionItem($bChinese ? '折价' : 'Lower', $netvalue_higher);
    _echoLofPredictionItem($bChinese ? '平价' : 'Same', $netvalue_same);
    _echoLofPredictionItem($bChinese ? '溢价' : 'Higher', $netvalue_lower);
    EchoTableEnd();
    
    EchoParagraphEnd();
}

function EchoThanousLawTest($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
        if (in_arrayLof($strSymbol))
        {
            PrefetchStockData(LofGetAllSymbolArray($strSymbol));
            $fund = new MyLofReference($strSymbol);
            _echoLofPredictionParagraph($fund->stock_ref, new StockHistory($fund->etf_ref), $bChinese);
        }
    }
    EchoPromotionHead('thanouslaw', $bChinese);
}

function EchoTitle($bChinese)
{
  	$str = UrlGetQueryDisplay('symbol', '');
    if ($bChinese)
    {
        $str .= '小心愿定律测试';
    }
    else
    {
        $str .= ' Thanous Law Test';
    }
    echo $str;
}

    AcctNoAuth();

?>

