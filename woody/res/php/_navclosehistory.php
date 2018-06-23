<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function _echoNavCloseGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2));
    $jpg->DrawCompareArray($csv->ReadColumn(1));
	$strPremium = $bChinese ? '溢价' : 'Premium';
    $jpg->Show($strPremium, $strSymbol, $csv->GetPathName());
}

function _echoNavCloseItem($csv, $history, $fund, $clone_ref)
{
	$strDate = $history['date'];
    $fClose = floatval($history['close']);
    $fNetValue = floatval($fund['close']);
    
    $strClose = strval($fClose);
    $strNetValue = StockGetPriceDisplay($fNetValue, $fClose);
    $strPercentage = StockGetPercentageDisplay($fClose, $fNetValue);
    $strStockPercentage = $clone_ref->GetCurrentPercentageDisplay();
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strStockPercentage</td>
    </tr>
END;

	if (empty($fNetValue) == false)
    {
    	$fPercentage = StockGetPercentage($fClose, $fNetValue);
    	$fStockPercentage = StockGetPercentage($clone_ref->fPrice, $clone_ref->fPrevPrice);
   		$csv->WriteArray(array($strDate, strval($fNetValue), strval($fPercentage), strval($fStockPercentage)));
    }
}

function _echoNavCloseData($sql, $ref, $iStart, $iNum)
{
	$clone_ref = clone $ref;
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($fund = mysql_fetch_assoc($result)) 
        {
        	$strDate = $fund['date'];
            if ($history = $sql->stock_sql->Get($strDate))
            {
            	if ($stock_ref = RefGetDailyClose($clone_ref, $sql->stock_sql, $strDate))
            	{
            		_echoNavCloseItem($csv, $history, $fund, $stock_ref);
            	}
            }
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoNavCloseParagraph($strSymbol, $strStockId, $iStart, $iNum, $bChinese)
{
    // StockPrefetchData($strSymbol);
    $ref = new MyStockReference($strSymbol);
    $arColumn = GetFundHistoryTableColumn($ref, $bChinese);
    
	$sql = new FundHistorySql($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
 
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
   
    _echoNavCloseData($sql, $ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoNavCloseGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
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
