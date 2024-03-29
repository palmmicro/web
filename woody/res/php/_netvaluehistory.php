<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('../../php/dateimagefile.php');

function _echoNetValueItem($csv, $nav_sql, $strStockId, $est_sql, $strEstId, $strNetValue, $strDate, $ref, $est_ref, $cny_ref)
{
	$bWritten = false;
	$ar = array($strDate, $strNetValue);
	if ($record = $nav_sql->GetRecordPrev($strStockId, $strDate))
    {
    	$strPrevDate = $record['date'];
    	$strPrev = rtrim0($record['close']);
		$ar[] = $ref->GetPercentageDisplay($strPrev, $strNetValue);

		if ($est_sql)
		{
			$strCny = $cny_ref->GetClose($strDate);
			$ar[] = $strCny;
			if ($strCnyPrev = $cny_ref->GetClose($strPrevDate))
			{
				$ar[] = $cny_ref->GetPercentageDisplay($strCnyPrev, $strCny);
			}
			else
			{
				$ar[] = '';
			}
		
			if ($strEst = $est_sql->GetClose($strEstId, $strDate))
			{
				$ar[] = $strEst;
				if ($strEstPrev = $est_sql->GetClose($strEstId, $strPrevDate))
				{
					$ar[] = $est_ref->GetPercentageDisplay($strEstPrev, $strEst);
					if ($strVal = QdiiGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny))
					{
						$bWritten = true;
						$csv->Write($strDate, $strNetValue, $strVal);
						$ar[] = $strVal;
					}
				}
			}
		}
	}
	
	if ($bWritten == false)		$csv->Write($strDate, $strNetValue);
	EchoTableColumn($ar);
}

function _echoNetValueData($csv, $ref, $est_ref, $cny_ref, $iStart, $iNum)
{
	$nav_sql = GetNavHistorySql();
	if ($est_ref)
	{
		$strEstId = $est_ref->GetStockId();
		$est_sql = $nav_sql;
		if ($est_sql->Count($strEstId) == 0 || $est_ref->IsIndex())
		{
			$est_sql = GetStockHistorySql();
		}
	}
	else
	{
		$est_sql = false;
		$strEstId = false;
	}

	$strStockId = $ref->GetStockId();
    if ($result = $nav_sql->GetAll($strStockId, $iStart, $iNum)) 
    {
        while ($record = mysqli_fetch_assoc($result)) 
        {
			_echoNetValueItem($csv, $nav_sql, $strStockId, $est_sql, $strEstId, rtrim0($record['close']), $record['date'], $ref, $est_ref, $cny_ref);
        }
        mysqli_free_result($result);
    }
}

function _echoNetValueHistory($ref, $iStart, $iNum, $bAdmin)
{
	if (($iTotal = $ref->CountNav()) == 0)	return;
	
	$strSymbol = $ref->GetSymbol();
    $str = GetFundLinks($strSymbol);
    if (in_arrayQdii($strSymbol))
    {
    	$ref = new QdiiReference($strSymbol);
    	$cny_ref = $ref->GetCnyRef();
    	$est_ref = $ref->GetEstRef();
    }
	else if (in_arrayQdiiHk($strSymbol))
    {
       	$ref = new QdiiHkReference($strSymbol);
        $cny_ref = $ref->GetCnyRef();
        $est_ref = $ref->GetEstRef();
    }
	else if (in_arrayQdiiJp($strSymbol))
    {
       	$ref = new QdiiJpReference($strSymbol);
        $cny_ref = $ref->GetCnyRef();
        $est_ref = $ref->GetEstRef();
    }
	else if (in_arrayQdiiEu($strSymbol))
    {
       	$ref = new QdiiEuReference($strSymbol);
        $cny_ref = $ref->GetCnyRef();
        $est_ref = $ref->GetEstRef();
    }
    else if ($strSymbol == 'SZ164906')
    {
       	$cny_ref = new CnyReference('USCNY');
       	$est_ref = new MyStockReference('KWEB');
    }
    else
    {
    	$cny_ref = false;
    	$est_ref = false;
    }
    if ($bAdmin)	$str .= '<br />'.StockGetAllLink($strSymbol);
    
   	$strMenuLink = StockGetMenuLink($strSymbol, $iTotal, $iStart, $iNum);
	$str .= '<br />'.$strMenuLink;

	$change_col = new TableColumnChange();
	$ar = array(new TableColumnDate(), new TableColumnNav(), $change_col);
	if ($est_ref)
	{
		$ar[] = new TableColumnStock($cny_ref);
		$ar[] = $change_col;
		$ar[] = RefGetTableColumnNav($est_ref);
		$ar[] = $change_col;
		$position_col = new TableColumnPosition();
		$ar[] = $position_col;
	}
	EchoTableParagraphBegin($ar, 'netvaluehistory', $str);
	
   	$csv = new PageCsvFile();
	_echoNetValueData($csv, $ref, $est_ref, $cny_ref, $iStart, $iNum);
    $csv->Close();
    
    $str = $strMenuLink;
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
   		if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))
   		{
   			$str .= '<br />'.$csv->GetLink().'<br />'.$jpg->GetAll(($est_ref ? $position_col->GetDisplay() : ''), $strSymbol);
   		}
   	}
    EchoTableParagraphEnd($str);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		_echoNetValueHistory($ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks('netvaluehistory');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(NETVALUE_HISTORY_DISPLAY);
    $str .= '页面。用于某基金历史净值超过一定数量后的显示。最近的基金净值记录一般会直接显示在该基金页面。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(NETVALUE_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();
?>

