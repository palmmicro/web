<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousLawCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[3]), floatval($arWord[2]));
    }
}

function _echoThanousLawPool($strSymbol, $strTradingSymbol, $bChinese)
{
   	$csv = new _ThanousLawCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $bChinese, $strSymbol, $strTradingSymbol, false);
}

function _echoThanousLawItem($csv, $strDate, $fNetValue, $fFundClose, $ref)
{
    $strNetValue = strval($fNetValue);
    $strFundClose = StockGetPriceDisplay($fFundClose, $fNetValue);
    $strPercentage = StockGetPercentageDisplay($fFundClose, $fNetValue);
    $strEstClose = $ref->GetCurrentPriceDisplay();
    $strEstChange = $ref->GetCurrentPercentageDisplay();
   	$csv->WriteArray(array($strDate, $strNetValue, strval($ref->GetCurrentPercentage()), strval(StockGetPercentage($fFundClose, $fNetValue))));

    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strFundClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strEstClose</td>
        <td class=c1>$strEstChange</td>
    </tr>
END;
}

function _echoThanousLawData($sql, $ref, $est_ref, $iStart, $iNum, $bChinese)
{
	$clone_ref = clone $est_ref;
	$est_sql = new StockHistorySql($est_ref->GetStockId());
	
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = GetNextTradingDayYMD($arFund['date']);
        		if ($arStock = $sql->stock_sql->Get($strDate))
        		{
        			if ($stock_ref = RefGetDailyClose($clone_ref, $est_sql, $strDate))
        			{
        				_echoThanousLawItem($csv, $strDate, $fNetValue, floatval($arStock['close']), $stock_ref);
        			}
                }
            }
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _getNetValueLink($strSymbol, $bChinese)
{
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    $strNetValue = GetNetValueHistoryLink($strSymbol, $bChinese);
    return $strGroupLink.$strNetValue;
}

function _echoThanousLawParagraph($strSymbol, $iStart, $iNum, $bChinese)
{
	$ref = new LofReference($strSymbol);
	$est_ref = $ref->est_ref;
    $arColumn = GetFundHistoryTableColumn($est_ref, $bChinese);
 	$str = _getNetValueLink($strSymbol, $bChinese);

	$sql = new FundHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=600 border=1 class="text" id="thanouslaw">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=100 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=100 align=center>{$arColumn[3]}</td>
        <td class=c1 width=100 align=center>{$arColumn[4]}</td>
        <td class=c1 width=100 align=center>{$arColumn[5]}</td>
    </tr>
END;

	_echoThanousLawData($sql, $ref, $est_ref, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);

    _echoThanousLawPool($strSymbol, $est_ref->GetStockSymbol(), $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
        if (in_arrayLof($strSymbol))
        {
            StockPrefetchData($strSymbol);
   			$iStart = UrlGetQueryInt('start');
   			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   			
            $fStart = microtime(true);
            _echoThanousLawParagraph($strSymbol, $iStart, $iNum, $bChinese);
            $fStop = microtime(true);
            DebugString($strSymbol.' Thanous Law: '.DebugGetStopWatchDisplay($fStop, $fStart));
        }
    }
    EchoPromotionHead($bChinese, 'thanouslaw');
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '小心愿定律测试' : ' Thanous Law Test');
}

    AcctAuth();

?>

