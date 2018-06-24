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

function _echoNavCloseItem($csv, $strDate, $fNetValue, $ref, $strFundId)
{
	$fClose = $ref->GetCurrentPrice();
    $strClose = StockGetPriceDisplay($fClose, $fNetValue);
    $strPercentage = StockGetPercentageDisplay($fClose, $fNetValue);
    $strStockPercentage = $ref->GetCurrentPercentageDisplay();
    $strNetValue = strval($fNetValue);
    
   	$fPercentage = StockGetPercentage($fClose, $fNetValue);
   	$fStockPercentage = $ref->GetCurrentPercentage();
	$csv->WriteArray(array($strDate, $strNetValue, strval($fPercentage), strval($fStockPercentage), strval($fClose)));
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_FUND_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strStockPercentage</td>
    </tr>
END;
}

function _echoNavCloseData($sql, $ref, $iStart, $iNum, $bTest)
{
	$clone_ref = clone $ref;
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $arFund['date'];
       			if ($stock_ref = RefGetDailyClose($clone_ref, $sql->stock_sql, $strDate))
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
   
    _echoNavCloseData($sql, $ref, $iStart, $iNum, AcctIsTest($bChinese));
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
