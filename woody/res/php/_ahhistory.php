<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function _echoAhHistoryItem($hshare_ref, $csv, $record, $h_his_sql, $hkcny_sql)
{
	$strDate = $record['date'];
	if ($strHKCNY = $hkcny_sql->GetClose($strDate))
	{
		$strClose = rtrim0($record['close']);
		$ar = array($strDate, $strHKCNY, $strClose);
		
		if ($strCloseH = $h_his_sql->GetClose($strDate))
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

function _echoAhHistoryData($csv, $hshare_ref, $his_sql, $iStart, $iNum)
{
	$h_his_sql = $hshare_ref->GetHistorySql();
    if ($result = $his_sql->GetAll($iStart, $iNum)) 
    {
    	$hkcny_sql = new HkcnyHistorySql();
        while ($record = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($hshare_ref, $csv, $record, $h_his_sql, $hkcny_sql);
        }
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($hshare_ref, $iStart, $iNum, $bAdmin)
{
	$strSymbol = $hshare_ref->GetSymbolA();
    $strSymbolH = $hshare_ref->GetStockSymbol();
 	
    $his_sql = $hshare_ref->a_ref->GetHistorySql();
    $strNavLink = StockGetNavLink($strSymbol, $his_sql->Count(), $iStart, $iNum);
    $str = $strNavLink; 
    if ($bAdmin)
    {
        $str .= ' '.GetUpdateStockHistoryLink($strSymbol);
        $str .= ' '.GetUpdateStockHistoryLink($strSymbolH);
    }

    $ah_col = new TableColumnAhRatio();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnHKCNY(),
								   new TableColumn($strSymbol),
								   new TableColumn($strSymbolH),
								   $ah_col,
								   new TableColumnHaRatio()
								   ), $strSymbol.'ahhistory', $str);

   	$csv = new PageCsvFile();
    _echoAhHistoryData($csv, $hshare_ref, $his_sql, $iStart, $iNum);
    $csv->Close();
    
    $str = $strNavLink;
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
    	$jpg->Draw($csv->ReadColumn(4), $csv->ReadColumn(1));
    	$str .= '<br />'.$csv->GetLink().'<br />'.$jpg->GetAll($ah_col->GetDisplay(), $strSymbol);
    }
    EchoTableParagraphEnd($str);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	if ($ref->HasData())
    	{
			if ($strSymbolH = SqlGetAhPair($ref->GetStockSymbol()))	
    		{
    			$hshare_ref = new HShareReference($strSymbolH);
    			_echoAhHistoryParagraph($hshare_ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    		}
    	}
    }
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().AH_HISTORY_DISPLAY;
    $str .= '页面. 按中国A股交易日期排序显示. 同时显示港币人民币中间价历史, 提供跟Yahoo或者Sina历史数据同步的功能.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().AH_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart();

?>
