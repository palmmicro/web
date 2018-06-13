<?php
require_once('_stock.php');
require_once('/php/ui/fundhistoryparagraph.php');

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
    
    function AddCompare($ref)
    {
        $this->iDays ++;
        
//        list($strClose, $strPrevClose) = $arClose;
        $fClose = $ref->fPrice;			// floatval($strClose);
        $fPrevClose = $ref->fPrevPrice;	// floatval($strPrevClose);
            
        if (($fClose - MIN_FLOAT_VAL) > $fPrevClose)          $this->iHigher ++;
        else if (($fClose + MIN_FLOAT_VAL) < $fPrevClose)    $this->iLower ++;        
        else                                                      $this->iUnchanged ++;
    }
}

// ****************************** LOF Prediction Paragraph *******************************************************

function _getNetValueLink($strSymbol, $bChinese)
{
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    $strNetValue = GetNetValueHistoryLink($strSymbol, $bChinese);
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

function _echoLofPredictionParagraphBegin($lof_ref, $est_ref, $bChinese)
{
    $strLofSymbol = $lof_ref->GetStockSymbol();
    $strEtfSymbol = $est_ref->GetStockSymbol();
    if ($bChinese)     
    {
        $arColumn = array($strLofSymbol.'交易', '天数', $strEtfSymbol.'涨', $strEtfSymbol.'不变', $strEtfSymbol.'跌');
    }
    else
    {
        $arColumn = array($strLofSymbol.' Trading', 'Days', $strEtfSymbol.' Higher', $strEtfSymbol.' Unchanged', $strEtfSymbol.' Lower');
    }

    echo <<<END
    <p>
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

function _echoLofPredictionParagraph($fund, $bChinese)
{
    $netvalue_higher = new PriceCompare();
    $netvalue_same = new PriceCompare();
    $netvalue_lower = new PriceCompare();
    
	$lof_ref = $fund->stock_ref;
    $strSymbol = $lof_ref->GetStockSymbol();
    $strStockId = $lof_ref->GetStockId();
    
	$est_ref = $fund->est_ref;
    $arColumn = FundHistoryTableGetColumn($est_ref, $bChinese);
    
	$clone_ref = false;
	if ($est_ref)
	{
		$est_sql = new StockHistorySql($est_ref->GetStockId());
		$clone_ref = clone $est_ref;
	}
    
    EchoParagraphBegin(_getNetValueLink($strSymbol, $bChinese));
    EchoFundHistoryTableBegin($arColumn);
	$sql = new FundHistorySql($strStockId);
    if ($result = $sql->GetAll(0, MAX_PREDICTION_DAYS)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strDate = GetNextTradingDayYMD($record['date']);
            if ($history = $sql->stock_sql->Get($strDate))
            {
                if ($ref = GetDailyCloseByDate($clone_ref, $est_sql, $strDate))
                {
                    $fNetValue = floatval($record['close']);
                    $fClose = floatval($history['close']);
                    if (($fNetValue - MIN_FLOAT_VAL) > $fClose)          $netvalue_higher->AddCompare($ref);
                    else if (($fNetValue + MIN_FLOAT_VAL) < $fClose)     $netvalue_lower->AddCompare($ref);        
                    else                                                     $netvalue_same->AddCompare($ref);

                    EchoFundHistoryTableItem($lof_ref, false, $history, $record, $ref);
                }
            }
        }
        @mysql_free_result($result);
    }
    EchoTableParagraphEnd();

    _echoLofPredictionParagraphBegin($lof_ref, $est_ref, $bChinese);
    _echoLofPredictionItem($bChinese ? '折价' : 'Lower', $netvalue_higher);
    _echoLofPredictionItem($bChinese ? '平价' : 'Same', $netvalue_same);
    _echoLofPredictionItem($bChinese ? '溢价' : 'Higher', $netvalue_lower);
    EchoTableParagraphEnd();
}

function EchoThanousLawTest($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
        if (in_arrayLof($strSymbol))
        {
            StockPrefetchData(array($strSymbol));
            $fStart = microtime(true);
            _echoLofPredictionParagraph(new LofReference($strSymbol), $bChinese);
            $fStop = microtime(true);
            DebugString($strSymbol.' Thanous Law: '.DebugGetStopWatchDisplay($fStop, $fStart));
        }
    }
    EchoPromotionHead($bChinese, 'thanouslaw');
}

function EchoTitle($bChinese)
{
  	$str = UrlGetQueryDisplay('symbol');
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

