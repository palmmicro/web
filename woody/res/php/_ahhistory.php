<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function _echoAhHistoryGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(4));
    $jpg->DrawCompareArray($csv->ReadColumn(1));
	$arColumn = GetAhCompareTableColumn();
    $jpg->Show($arColumn[1], $strSymbol, $csv->GetPathName());
}

function _echoAhHistoryItem($csv, $record, $pair_sql, $hkcny_sql, $fRatio)
{
	$strDate = $record['date'];
	$strClose = round_display_str($record['close']);
	
	if ($strHKCNY = $hkcny_sql->GetClose($strDate))	$strHKCNY = round_display_str($strHKCNY);
	else													$strHKCNY = '';
	
	$strAH = '';
	$strHA = '';
	if ($strPairClose = $pair_sql->GetClose($strDate))
	{
		$strPairClose = round_display_str($strPairClose);
		if ($strHKCNY)
		{
			$fAh = floatval($strClose) / HShareEstToCny(floatval($strPairClose), $fRatio, floatval($strHKCNY));
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
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($csv, $record, $pair_sql, $hkcny_sql, $fRatio);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $fRatio, $iStart, $iNum)
{
    $arColumn = array(GetTableColumnDate());
    $arColumn[] = $strSymbol;
    $strPairSymbol = SqlGetStockSymbol($strPairId);
    $arColumn[] = GetMyStockLink($strPairSymbol);
	$arColumn = array_merge($arColumn, GetAhCompareTableColumn());
    $arColumn[3] = GetMyStockLink('HKCNY');
	
    $strUpdateLink = ''; 
    if (AcctIsAdmin())
    {
        $strUpdateLink = GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strStockId, "确认更新$strSymbol历史记录?", $strSymbol);
        $strUpdateLink .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strPairId, "确认更新$strPairSymbol历史记录?", $strPairSymbol);
    }

	$sql = new StockHistorySql($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
 
    echo <<<END
    <p>$strNavLink $strUpdateLink
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

    _echoAhHistoryGraph($strSymbol);
}

function EchoAll()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();	
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$sql = new PairStockSql($strStockId, TABLE_AH_STOCK);
    		if ($strPairId = $sql->GetPairId())
    		{
    			$iStart = UrlGetQueryInt('start');
    			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    			_echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $sql->GetRatio(), $iStart, $iNum);
    		}
    	}
    }
    EchoPromotionHead();
    EchoStockCategory();
}

function EchoMetaDescription()
{
    $str = UrlGetQueryDisplay('symbol');
    $str .= '中国A股和香港H股历史价格比较页面. 按A股交易日期排序显示. 同时显示港币人民币中间价历史, 提供跟Yahoo或者Sina历史数据同步的功能.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo UrlGetQueryDisplay('symbol').AH_HISTORY_DISPLAY;
}

    AcctAuth();

?>
