<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('../../php/dateimagefile.php');
require_once('../../php/ui/editinputform.php');

function _echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $strPrevDate, $nav_sql, $strStockId, $est_sql, $strEstId, $strInput, $bAdmin)
{
	$bWritten = false;
	$ar = array($strDate, $strNetValue);
	
   	$strPrev = $nav_sql->GetClose($strStockId, $strPrevDate);
	$ar[] = $ref->GetPercentageDisplay($strPrev, $strNetValue);

	$strCny = $cny_ref->GetClose($strDate);
	$ar[] = $strCny;
	if ($strCnyPrev = $cny_ref->GetClose($strPrevDate))		$ar[] = $cny_ref->GetPercentageDisplay($strCnyPrev, $strCny);
	else															$ar[] = '';
		
	if ($strEst = $est_sql->GetClose($strEstId, $strDate))
	{
		$ar[] = $strEst;
		if ($strEstPrev = $est_sql->GetClose($strEstId, $strPrevDate))
		{
			$ar[] = $est_ref->GetPercentageDisplay($strEstPrev, $strEst);
			if ($strPosition = QdiiGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny, $strInput))
			{
				$bWritten = true;
				$strArbitrage = QdiiGetStockArbitrage($strEst, $strNetValue, $strCny, $strPosition);
				$csv->Write($strDate, $strNetValue, $strPosition, $strArbitrage);
				
				if ($bAdmin)	$strPosition = GetOnClickLink('/php/_submitoperation.php?stockid='.$strStockId.'&fundposition='.$strPosition, "确认使用{$strPosition}作为估值仓位？", $strPosition);
				$ar[] = $strPosition;	// .'/'.$strArbitrage;
			}
		}
	}

	if ($bWritten == false)		$csv->Write($strDate, $strNetValue);
	EchoTableColumn($ar);
}

function _getSwitchDateArray($nav_sql, $strStockId, $est_sql, $strEstId)
{
	$arDate = array();
	$bFirst = true;
    if ($result = $nav_sql->GetAll($strStockId)) 
    {
        while ($record = mysqli_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		if ($strEst = $est_sql->GetClose($strEstId, $strDate))
       		{
       			$fCur = floatval($strEst);
       			if ($bFirst)
       			{
       				$arDate[] = $strDate;
       				$bSecond = true;
       				$bFirst = false;
       			}
       			else
       			{
       				if ($bSecond)
       				{
       					$bUp = ($fOld > $fCur) ? true : false;
       					$bSecond = false;
       				}
       				else
       				{
       					if ($bUp)
       					{
       						if ($fOld < $fCur)
       						{
       							$bUp = false;
       							$arDate[] = $strOldDate;
       						}
       					}
       					else
       					{
       						if ($fOld > $fCur)
       						{
       							$bUp = true;
       							$arDate[] = $strOldDate;
       						}
       					}
       				}
       			}
   				$fOld = $fCur;
   				$strOldDate = $strDate;
       		}
        }
        mysqli_free_result($result);
    }
    return $arDate;
}
	
function _echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput, $bAdmin)
{
   	$strStockId = $ref->GetStockId();
	$strEstId = $est_ref->GetStockId();
	$nav_sql = GetNavHistorySql();
	$est_sql = ($est_ref->CountNav() > 0) ? $nav_sql : GetStockHistorySql(); 

	$arDate = _getSwitchDateArray($nav_sql, $strStockId, $est_sql, $strEstId);
	if (count($arDate) == 0)		return;
 
 	$iIndex = 0;
    if ($result = $nav_sql->GetAll($strStockId)) 
    {
        while ($record = mysqli_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		$strNetValue = rtrim0($record['close']);
       		if ($strDate == $arDate[$iIndex])
       		{
   				$iIndex ++;
   				if (isset($arDate[$iIndex]))	_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $nav_sql, $strStockId, $est_sql, $strEstId, $strInput, $bAdmin);
   				else
   				{
   					$csv->Write($strDate, $strNetValue);
   					break;
       			}
       		}
       		else	$csv->Write($strDate, $strNetValue);
        }
        mysqli_free_result($result);
    }
}

function _echoFundPositionParagraph($ref, $cny_ref, $est_ref, $strSymbol, $strInput, $bAdmin)
{
 	$str = GetFundLinks($strSymbol);
	$change_col = new TableColumnChange();
	$position_col = new TableColumnPosition();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnNav(),
								   $change_col,
								   new TableColumnStock($cny_ref),
								   $change_col,
								   RefGetTableColumnNav($est_ref),
								   $change_col,
								   $position_col
								   ), 'fundposition', $str);
	
	$csv = new PageCsvFile();
	_echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput, $bAdmin);
	$csv->Close();
	
	if ($csv->HasFile())
	{
		$strNewLine = GetBreakElement();
		$str = $strNewLine.$csv->GetLink();

		$jpg = new DateImageFile();
		if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))
		{
			$str .= $strNewLine.$jpg->GetAll($position_col->GetDisplay(), $strSymbol);
		}

		$jpg2 = new DateImageFile(2);
		if ($jpg2->Draw($csv->ReadColumn(3), $csv->ReadColumn(1)))
		{
			$str .= $strNewLine.'&nbsp;'.$strNewLine.$jpg2->GetAll('对冲值', $strSymbol);
		}
		EchoTableParagraphEnd($str);
   	}
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	if (isset($_POST['submit']))
    	{
    		unset($_POST['submit']);
    		$strInput = SqlCleanString($_POST[EDIT_INPUT_NAME]);
    	}
    	else	$strInput = POSITION_EST_LEVEL;
    	EchoEditInputForm('进行估算的涨跌阈值', $strInput);
    	
   		$fund = false;
   		$strSymbol = $ref->GetSymbol();
        if (in_arrayQdii($strSymbol))
        {
        	$fund = new QdiiReference($strSymbol);
        	$cny_ref = $fund->GetCnyRef();
        	$est_ref = $fund->GetEstRef();
        }
		else if (in_arrayQdiiHk($strSymbol))
        {
        	$fund = new QdiiHkReference($strSymbol);
        	$cny_ref = $fund->GetCnyRef();
        	$est_ref = $fund->GetEstRef();
        }
		else if (in_arrayQdiiJp($strSymbol))
        {
        	$fund = new QdiiJpference($strSymbol);
        	$cny_ref = $fund->GetCnyRef();
        	$est_ref = $fund->GetEstRef();
        }
		else if (in_arrayQdiiEu($strSymbol))
        {
        	$fund = new QdiiEuference($strSymbol);
        	$cny_ref = $fund->GetCnyRef();
        	$est_ref = $fund->GetEstRef();
        }
        else if ($strSymbol == 'SZ164906')
        {
        	$fund = $ref;
        	$cny_ref = new CnyReference('USCNY');
        	$est_ref = new MyStockReference('KWEB');
        }
		if ($fund)		_echoFundPositionParagraph($fund, $cny_ref, $est_ref, $strSymbol, $strInput, $acct->IsAdmin());
    }
    $acct->EchoLinks('fundposition');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_POSITION_DISPLAY;
    $str .= '。仅用于美股QDII基金，寻找对应美股ETF净值连续几天累计涨跌超过4%的机会测算A股基金的实际持仓仓位。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetSymbolDisplay().FUND_POSITION_DISPLAY;
}

    $acct = new SymbolAccount();
?>

