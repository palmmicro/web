<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/dateimagefile.php');

function _echoAhHistoryItem($hshare_ref, $csv, $record, $his_sql, $strStockIdH)
{
	$strDate = $record['date'];
	if ($strHKCNY = $hshare_ref->hkcny_ref->GetClose($strDate))
	{
		$strClose = rtrim0($record['close']);
		$ar = array($strDate, $strHKCNY, $strClose);
		
		if ($strCloseH = $his_sql->GetClose($strStockIdH, $strDate))
		{
			$fAh = floatval($strClose) / floatval($hshare_ref->EstToCny($strCloseH, $strHKCNY));
			$csv->Write($strDate, $strClose, $strCloseH, $strHKCNY, strval_round($fAh));
			
			$ar[] = $strCloseH;
			$ar[] = GetRatioDisplay($fAh);
			$ar[] = GetRatioDisplay(1.0 / $fAh);
		}
		
		EchoTableColumn($ar);
	}
}

function _echoAhHistoryData($csv, $hshare_ref, $his_sql, $strStockId, $strStockIdH, $iStart, $iNum)
{
    if ($result = $his_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($hshare_ref, $csv, $record, $his_sql, $strStockIdH);
        }
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($hshare_ref, $iStart, $iNum, $bAdmin)
{
	$strSymbol = $hshare_ref->GetSymbolA();
    $strSymbolH = $hshare_ref->GetSymbol();
 	
	$his_sql = GetStockHistorySql();
    $strStockId = $hshare_ref->a_ref->GetStockId();
    $strMenuLink = StockGetMenuLink($strSymbol, $his_sql->Count($strStockId), $iStart, $iNum);
    $str = $strMenuLink; 
    if ($bAdmin)
    {
        $str .= ' '.GetUpdateStockHistoryLink($strSymbol);
        $str .= ' '.GetUpdateStockHistoryLink($strSymbolH);
    }

    $ah_col = new TableColumnAhRatio();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnStock('HKCNY'),
								   new TableColumnStock($strSymbol),
								   new TableColumnStock($strSymbolH),
								   $ah_col,
								   new TableColumnHaRatio()
								   ), $strSymbol.'ahhistory', $str);

   	$csv = new PageCsvFile();
    _echoAhHistoryData($csv, $hshare_ref, $his_sql, $strStockId, $hshare_ref->GetStockId(), $iStart, $iNum);
    $csv->Close();
    
    $str = $strMenuLink;
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
    	if ($jpg->Draw($csv->ReadColumn(4), $csv->ReadColumn(1)))
    	{
    		$str .= '<br />'.$csv->GetLink().'<br />'.$jpg->GetAll($ah_col->GetDisplay(), $strSymbol);
    	}
    }
    EchoTableParagraphEnd($str);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
		if ($strSymbolH = SqlGetAhPair($ref->GetSymbol()))	
   		{
   			$hshare_ref = new HShareReference($strSymbolH);
   			_echoAhHistoryParagraph($hshare_ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    	}
    }
    $acct->EchoLinks();
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(AH_HISTORY_DISPLAY);
    $str .= '页面. 按中国A股交易日期排序显示. 同时显示港币人民币中间价历史, 提供跟Yahoo或者Sina历史数据同步的功能. 仅包括2014-01-01以后的数据.';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(AH_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();
?>
