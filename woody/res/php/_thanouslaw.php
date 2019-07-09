<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _ThanousLawCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[2]), floatval($arWord[1]));
    }
}

function _echoThanousLawPool($strSymbol, $strTradingSymbol)
{
   	$csv = new _ThanousLawCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $strSymbol, $strTradingSymbol, false);
}

function _echoThanousLawItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref)
{
	$his_sql = $est_ref->GetHistorySql();
	$strEstClose = $his_sql->GetClose($strDate);
	$strEstClosePrev = $his_sql->GetClosePrev($strDate);
	if (($strEstClose == false) || ($strEstClosePrev == false))		return;
	
   	$csv->Write($strDate, $est_ref->GetPercentage($strEstClosePrev, $strEstClose), $ref->GetPercentage($strNetValue, $strClose), $strNetValue);
   	
    $strPremium = $ref->GetPercentageDisplay($strNetValue, $strClose);
    $strClose = $ref->GetPriceDisplay($strClose, $strNetValue);
    
    $strEstChange = $est_ref->GetPercentageDisplay($strEstClosePrev, $strEstClose);
    $strEstClose = $est_ref->GetPriceDisplay($strEstClose, $strEstClosePrev);

    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strEstClose</td>
        <td class=c1>$strEstChange</td>
    </tr>
END;
}

function _echoThanousLawData($sql, $ref, $est_ref, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$strNetValue = rtrim0($record['close']);
        	if (empty($strNetValue) == false)
        	{
        		$strDate = GetNextTradingDayYMD($record['date']);
        		if ($strClose = $ref->his_sql->GetClose($strDate))
        		{
       				_echoThanousLawItem($csv, $strNetValue, $strClose, $strDate, $ref, $est_ref);
                }
            }
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoThanousLawParagraph($strSymbol, $iStart, $iNum)
{
	$ref = new LofReference($strSymbol);
	$est_ref = $ref->est_ref;
    $arColumn = GetFundHistoryTableColumn($est_ref);
 	$str = GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);

	$sql = new NetValueHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
    echo <<<END
    <p>$str $strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=460 border=1 class="text" id="thanouslaw">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=70 align=center>{$arColumn[1]}</td>
        <td class=c1 width=70 align=center>{$arColumn[2]}</td>
        <td class=c1 width=70 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=70 align=center>{$arColumn[5]}</td>
    </tr>
END;

	_echoThanousLawData($sql, $ref->stock_ref, $est_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoThanousLawPool($strSymbol, $est_ref->GetStockSymbol());
}

function EchoAll()
{
	global $group;
	
    if ($ref = $group->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
   			$iStart = UrlGetQueryInt('start');
   			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   			
            $fStart = microtime(true);
            _echoThanousLawParagraph($strSymbol, $iStart, $iNum);
            DebugString($strSymbol.' Thanous Law: '.DebugGetStopWatchDisplay($fStart));
        }
    }
    $group->EchoLinks('thanouslaw');
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().THANOUS_LAW_DISPLAY;
    $str .= '测试. 仅用于华宝油气(SZ162411)等LOF基金. 看白天A股华宝油气的溢价或者折价交易是否可以像小心愿认为的那样预测晚上美股XOP的涨跌.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().THANOUS_LAW_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage();

?>

