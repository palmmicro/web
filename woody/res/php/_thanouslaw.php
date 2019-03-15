<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousLawCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[2]), floatval($arWord[1]));
    }
}

function _echoThanousLawPool($strSymbol, $strTradingSymbol, $bChinese)
{
   	$csv = new _ThanousLawCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol, $strTradingSymbol, false);
}

function _echoThanousLawItem($csv, $strDate, $ref, $pair_ref)
{
    $strNetValue = $ref->GetPrevPrice();
    $strClose = $ref->GetCurrentPriceDisplay();
    $strPremium = $ref->GetCurrentPercentageDisplay();
    $strPairClose = $pair_ref->GetCurrentPriceDisplay();
    $strPairChange = $pair_ref->GetCurrentPercentageDisplay();
   	$csv->Write($strDate, strval($pair_ref->GetCurrentPercentage()), strval($ref->GetCurrentPercentage()), $strNetValue);

    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strPairClose</td>
        <td class=c1>$strPairChange</td>
    </tr>
END;
}

function _echoThanousLawData($sql, $ref, $est_ref, $iStart, $iNum, $bChinese)
{
    $stock_sql = new StockHistorySql($ref->GetStockId());
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
        		if ($arStock = $stock_sql->Get($strDate))
        		{
        			if ($pair_ref = RefGetDailyClose($est_ref, $est_sql, $strDate))
        			{
        				$ref->SetPrice(strval($fNetValue), $arStock['close']);
        				_echoThanousLawItem($csv, $strDate, $ref, $pair_ref);
        			}
                }
            }
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoThanousLawParagraph($strSymbol, $iStart, $iNum, $bChinese)
{
	$ref = new LofReference($strSymbol);
	$est_ref = $ref->est_ref;
    $arColumn = GetFundHistoryTableColumn($est_ref, $bChinese);
 	$str = GetNetValueHistoryLink($strSymbol, $bChinese);

	$sql = new NavHistorySql($ref->GetStockId());
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

	_echoThanousLawData($sql, $ref->stock_ref, $est_ref, $iStart, $iNum, $bChinese);
    EchoTableParagraphEnd($strNavLink);

    _echoThanousLawPool($strSymbol, $est_ref->GetStockSymbol(), $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();
        if (in_arrayLof($strSymbol))
        {
   			$iStart = UrlGetQueryInt('start');
   			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   			
            $fStart = microtime(true);
            _echoThanousLawParagraph($strSymbol, $iStart, $iNum, $bChinese);
            DebugString($strSymbol.' Thanous Law: '.DebugGetStopWatchDisplay($fStart));
        }
    }
    EchoPromotionHead('thanouslaw');
    EchoStockCategory();
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '小心愿定律测试' : ' Thanous Law Test');
}

    AcctAuth();

?>

