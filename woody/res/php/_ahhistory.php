<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function _echoAhHistoryGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(4));
    $jpg->DrawCompareArray($csv->ReadColumn(1));
	$arColumn = GetAhCompareTableColumn($bChinese);
    $jpg->Show($arColumn[1], $strSymbol, $csv->GetPathName());
}

function _echoAhHistoryItem($csv, $history, $pair_sql, $hkcny_sql, $fRatio)
{
	$strDate = $history['date'];
	$fClose = floatval($history['close']);
	$strClose = round_display($fClose);
	
	if ($fHKCNY = $hkcny_sql->GetClose($strDate))		$strHKCNY = round_display($fHKCNY);
	else													$strHKCNY = '';
	
	$strAH = '';
	$strHA = '';
	if ($fPairClose = $pair_sql->GetClose($strDate))
	{
		$strPairClose = round_display($fPairClose);
		if ($fHKCNY)
		{
			$fAh = $fClose / HShareEstToCny($fPairClose, $fRatio, $fHKCNY);
			$strAH = GetRatioDisplay($fAh);
			$strHA = GetRatioDisplay(1.0 / $fAh);
			$csv->Write($strDate, $strClose, $strPairClose, $strHKCNY, round_display($fAh));
		}
	}
	else
	{
		$strPairClose = '';
	}
	
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strPairClose</td>
        <td class=c1>$strHKCNY</td>
        <td class=c1>$strAH</td>
        <td class=c1>$strHA</td>                                                                                              
    </tr>
END;
}

function _echoAhHistoryData($sql, $strPairId, $fRatio, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
    	$hkcny_sql = new HkcnyHistorySql();
    	$pair_sql = new StockHistorySql($strPairId);
     	$csv = new PageCsvFile();
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($csv, $history, $pair_sql, $hkcny_sql, $fRatio);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $fRatio, $iStart, $iNum, $bChinese)
{
    if ($bChinese)  $arColumn = array('日期');
    else              $arColumn = array('Date');
    $arColumn[] = GetMyStockLink($strSymbol, $bChinese);
    $strPairSymbol = SqlGetStockSymbol($strPairId);
    $arColumn[] = GetMyStockLink($strPairSymbol, $bChinese);
	$arColumn = array_merge($arColumn, GetAhCompareTableColumn($bChinese));
    $arColumn[3] = GetMyStockLink('HKCNY', $bChinese);
	
    $strUpdateLink = ''; 
    if (AcctIsTest($bChinese))
    {
        $strUpdateLink = GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strStockId, "确认更新$strSymbol历史记录?", $strSymbol);
        $strUpdateLink .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strPairId, "确认更新$strPairSymbol历史记录?", $strPairSymbol);
    }

	$sql = new StockHistorySql($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
 
    EchoParagraphBegin($strNavLink.' '.$strUpdateLink);
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=530 border=1 class="text" id="ahhistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=80 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=110 align=center>{$arColumn[5]}</td>
    </tr>
END;
   
    _echoAhHistoryData($sql, $strPairId, $fRatio, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoAhHistoryGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$sql = new PairStockSql($strStockId, TABLE_AH_STOCK);
    		if ($strPairId = $sql->GetPairId())
    		{
    			$iStart = UrlGetQueryInt('start');
    			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    			_echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $sql->GetRatio(), $iStart, $iNum, $bChinese);
    		}
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '历史AH价格比较' : ' AH History Compare');
}

    AcctAuth();

?>
