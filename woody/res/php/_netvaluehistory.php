<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function _echoNetValueHistoryGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new DateImageFile();
    $ar = $csv->ReadColumn(1);
   	if (count($ar) > 0)
   	{
   		$jpg->DrawDateArray($ar);
   		$jpg->Show($strSymbol, '', $csv->GetLink());
   	}
}

function _echoNetValueItem($csv, $sql, $est_sql, $cny_sql, $strNetValue, $strDate, $ref, $est_ref, $cny_ref)
{
   	$csv->Write($strDate, $strNetValue);
   	
	$ar = array($strDate, $strNetValue);
	if ($record = $sql->GetPrev($strDate))
    {
    	$strPrevDate = $record['date'];
    	$strPrev = rtrim0($record['close']);
		$ar[] = $ref->GetPercentageDisplay($strPrev, $strNetValue);

		if ($est_sql)
		{
			$strCny = $cny_sql->GetClose($strDate);
			$ar[] = $strCny;
			if ($strCnyPrev = $cny_sql->GetClose($strPrevDate))
			{
				$ar[] = $cny_ref->GetPercentageDisplay($strCnyPrev, $strCny);
			}
			else
			{
				$ar[] = '';
			}
		
			if ($strEst = $est_sql->GetClose($strDate))
			{
				$ar[] = $strEst;
				if ($strEstPrev = $est_sql->GetClose($strPrevDate))
				{
					$ar[] = $est_ref->GetPercentageDisplay($strEstPrev, $strEst);
				
					$fEst = StockGetPercentage($strEstPrev, $strEst);
					if (abs($fEst) > 2.0 && $strCnyPrev)
					{
						$fVal = (StockGetPercentage($strPrev, $strNetValue) - StockGetPercentage($strCnyPrev, $strCny)) / $fEst;
						$ar[] = strval_round($fVal, 2);
					}
				}
			}
		}
	}
	
	EchoTableColumn($ar);
}

function _echoNetValueData($sql, $ref, $est_ref, $cny_ref, $iStart, $iNum)
{
	if ($est_ref)
	{
		$est_sql = new NetValueHistorySql($est_ref->GetStockId());
		$cny_sql = new UscnyHistorySql();
	}
	else
	{
		$est_sql = false;
		$cny_sql = false;
	}

    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
			_echoNetValueItem($csv, $sql, $est_sql, $cny_sql, rtrim0($record['close']), $record['date'], $ref, $est_ref, $cny_ref);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoNetValueHistory($ref, $iStart, $iNum)
{
	$strSymbol = $ref->GetStockSymbol();
    $str = GetFundHistoryLink($strSymbol);
    $str .= ' '.GetStockHistoryLink($strSymbol);
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetThanousLawLink($strSymbol);
    	$str .= ' '.GetFundAccountLink($strSymbol);
    	
        $cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
    	$ref = new LofReference($strSymbol);
    	$est_ref = $ref->est_ref;
    }
    else
    {
    	$cny_ref = false;
    	$est_ref = false;
    }
    
	$sql = new NetValueHistorySql($ref->GetStockId());
   	$strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum);
	$str .= ' '.$strNavLink;

	$change_col = new TableColumnChange();
	$ar = array(new TableColumnDate(), new TableColumnNetValue(), $change_col);
	if ($est_ref)
	{
		$ar[] = new TableColumnMyStock('USCNY');
		$ar[] = $change_col;
		$ar[] = new TableColumnNetValue($est_ref->GetStockSymbol());
		$ar[] = $change_col;
		$ar[] = new TableColumn('仓位(%)', 70);
	}
	EchoTableParagraphBegin($ar, 'netvalue', $str);
	_echoNetValueData($sql, $ref, $est_ref, $cny_ref, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);
    
    _echoNetValueHistoryGraph($strSymbol);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		_echoNetValueHistory($ref, $acct->GetStart(), $acct->GetNum());
    }
    $acct->EchoLinks('netvalue');
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().NETVALUE_HISTORY_DISPLAY;
    $str .= '页面. 用于某基金历史净值超过一定数量后的显示. 最近的基金净值记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等LOF基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().NETVALUE_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart();

?>

