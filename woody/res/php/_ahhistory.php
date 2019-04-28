<?php
require_once('_stock.php');
require_once('_emptygroup.php');
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

function _echoAhHistoryItem($csv, $record, $h_his_sql, $hkcny_sql, $fRatio)
{
	$strDate = $record['date'];
	$strClose = strval_round(floatval($record['close']));
	
	if ($strHKCNY = $hkcny_sql->GetClose($strDate))		$strHKCNY = strval_round(floatval($strHKCNY));
	else													$strHKCNY = '';
	
	$strAH = '';
	$strHA = '';
	if ($strCloseH = $h_his_sql->GetClose($strDate))
	{
		$strCloseH = strval_round(floatval($strCloseH));
		if ($strHKCNY)
		{
			$fAh = floatval($strClose) / HShareEstToCny(floatval($strCloseH), $fRatio, floatval($strHKCNY));
			$strAH = GetRatioDisplay($fAh);
			$strHA = GetRatioDisplay(1.0 / $fAh);
			$csv->Write($strDate, $strClose, $strCloseH, $strHKCNY, strval_round($fAh));
		}
	}
	else
	{
		$strCloseH = '';
	}
	
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strCloseH</td>
        <td class=c1>$strHKCNY</td>
        <td class=c1>$strAH</td>
        <td class=c1>$strHA</td>                                                                                              
    </tr>
END;
}

function _echoAhHistoryData($his_sql, $h_his_sql, $fRatio, $iStart, $iNum)
{
    if ($result = $his_sql->GetAll($iStart, $iNum)) 
    {
    	$hkcny_sql = new HkcnyHistorySql();
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($csv, $record, $h_his_sql, $hkcny_sql, $fRatio);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($ref, $h_ref, $iStart, $iNum, $bAdmin)
{
	$strSymbol = $ref->GetStockSymbol();
    $strSymbolH = $h_ref->GetStockSymbol();
 	
	$strDate = GetTableColumnDate();
    $strHKCNY = GetMyStockLink('HKCNY');
	$arColumn = GetAhCompareTableColumn();
	
    $strUpdateLink = ''; 
    if ($bAdmin)
    {
        $strUpdateLink = GetUpdateStockHistoryLink($strSymbol);
        $strUpdateLink .= ' '.GetUpdateStockHistoryLink($strSymbolH);
    }

    $his_sql = $ref->GetHistorySql();
    $strNavLink = StockGetNavLink($strSymbol, $his_sql->Count(), $iStart, $iNum);
 
    echo <<<END
    <p>$strNavLink $strUpdateLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=530 border=1 class="text" id="ahhistory">
    <tr>
        <td class=c1 width=100 align=center>$strDate</td>
        <td class=c1 width=80 align=center>$strSymbol</td>
        <td class=c1 width=80 align=center>$strSymbolH</td>
        <td class=c1 width=80 align=center>$strHKCNY</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=110 align=center>{$arColumn[2]}</td>
    </tr>
END;
   
    _echoAhHistoryData($his_sql, $h_ref->GetHistorySql(), SqlGetAhPairRatio($ref), $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoAhHistoryGraph($strSymbol);
}

function EchoAll()
{
	global $group;
	
	$bAdmin = $group->IsAdmin();
    if ($ref = $group->EchoStockGroup())
    {
    	if ($ref->HasData())
    	{
			if ($strSymbolH = SqlGetAhPair($ref->GetStockSymbol()))	
    		{
    			$iStart = UrlGetQueryInt('start');
    			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    			$h_ref = new MyStockReference($strSymbolH);
    			_echoAhHistoryParagraph($ref, $h_ref, $iStart, $iNum, $bAdmin);
    		}
    	}
    }
    $group->EchoLinks();
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().AH_HISTORY_DISPLAY;
    $str .= '页面. 按中国A股交易日期排序显示. 同时显示港币人民币中间价历史, 提供跟Yahoo或者Sina历史数据同步的功能.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().AH_HISTORY_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage();

?>
