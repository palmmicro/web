<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/pricepoolparagraph.php');

class _NavCloseCsvFile extends PricePoolCsvFile
{
    function OnLineArray($arWord)
    {
    	$this->pool->OnData(floatval($arWord[1]), floatval($arWord[2]));
    }
}

function _echoNavClosePool($strSymbol, $bChinese)
{
   	$csv = new _NavCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $bChinese, $strSymbol);
}

function _echoNavCloseGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2));
    $jpg->DrawCompareArray($csv->ReadColumn(3));
	$strPremium = $bChinese ? '溢价' : 'Premium';
    $jpg->Show($strPremium, $strSymbol, $csv->GetPathName());
}

function _echoNavCloseItem($csv, $strDate, $fNetValue, $ref, $strFundId)
{
    $fChange = $ref->GetCurrentPercentage();
    $strChange = $ref->GetCurrentPercentageDisplay();
	
    $strNetValue = strval($fNetValue);
	$ref->SetPrice($strNetValue);
    $strClose = $ref->GetCurrentPriceDisplay();
   	$strPremium = $ref->GetCurrentPercentageDisplay();
	$csv->Write($strDate, strval($fChange), strval($ref->GetCurrentPercentage()), $strNetValue);
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_NAV_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
        <td class=c1>$strChange</td>
    </tr>
END;
}

function _echoNavCloseData($sql, $ref, $iStart, $iNum, $bTest)
{
    $stock_sql = new StockHistorySql($ref->GetStockId());
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $arFund['date'];
       			if ($stock_ref = RefGetDailyClose($ref, $stock_sql, $strDate))
       			{
       				_echoNavCloseItem($csv, $strDate, $fNetValue, $stock_ref, ($bTest ? $arFund['id'] : false));
        		}
        	}
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoNavCloseParagraph($strSymbol, $strStockId, $iStart, $iNum, $bChinese)
{
	$sql = new NavHistorySql($strStockId);
	$iTotal = $sql->Count();
	if ($iTotal == 0)		return;
    $strNavLink = StockGetNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);

    $ref = new MyStockReference($strSymbol);
    $arColumn = GetFundHistoryTableColumn($ref, $bChinese);
    
    echo <<<END
    <p>$strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=500 border=1 class="text" id="navclosehistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=100 align=center>{$arColumn[4]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=100 align=center>{$arColumn[3]}</td>
        <td class=c1 width=100 align=center>{$arColumn[5]}</td>
    </tr>
END;
   
    _echoNavCloseData($sql, $ref, $iStart, $iNum, AcctIsTest($bChinese));
    EchoTableParagraphEnd($strNavLink);

    _echoNavClosePool($strSymbol, $bChinese);
    _echoNavCloseGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph($bChinese);
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
   			$iStart = UrlGetQueryInt('start');
   			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   			_echoNavCloseParagraph($strSymbol, $strStockId, $iStart, $iNum, $bChinese);
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '净值和收盘价历史比较' : ' NAV Close History Compare');
}

    AcctAuth();

?>
