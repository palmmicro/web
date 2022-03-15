<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/dateimagefile.php');
require_once('/php/ui/editinputform.php');

function _echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $strPrevDate, $nav_sql, $strStockId, $est_sql, $strEstId, $strInput, $bAdmin)
{
	$bWritten = false;
	$ar = array();
	$ar[] = $csv ? $strDate : $strPrevDate;
	$ar[] = $strNetValue;
	
   	$strPrev = $nav_sql->GetClose($strStockId, $strPrevDate);
	$ar[] = $ref->GetPercentageDisplay($strPrev, $strNetValue);

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
//		$strEst = strval(floatval($strEst) + 0.378235);
		$ar[] = $strEst;
		if ($strEstPrev = $est_sql->GetClose($strEstId, $strPrevDate))
		{
			$ar[] = $est_ref->GetPercentageDisplay($strEstPrev, $strEst);
			if ($strPosition = QdiiGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny, $strInput))
			{
				$bWritten = true;
				$strCalibration = QdiiGetStockCalibration($strEst, $strNetValue, $strCny, $strPosition);
				if ($csv)	$csv->Write($strDate, $strNetValue, $strPosition, $strCalibration);
				
				if ($bAdmin)	$strPosition = GetOnClickLink('/php/_submitoperation.php?stockid='.$strStockId.'&fundposition='.$strPosition, "确认使用{$strPosition}作为估值仓位？", $strPosition);
				$ar[] = $strPosition.'/'.$strCalibration;
			}
		}
	}

	if ($bWritten == false)
	{
		if ($csv)	$csv->Write($strDate, $strNetValue);
	}
	EchoTableColumn($ar);
}

function _getSwitchDateArray($nav_sql, $strStockId, $est_sql, $strEstId)
{
	$arDate = array();
	$bFirst = true;
    if ($result = $nav_sql->GetAll($strStockId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
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
        @mysql_free_result($result);
    }
    return $arDate;
}
	
function _echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput, $bAdmin)
{
   	$strStockId = $ref->GetStockId();
	$nav_sql = GetNavHistorySql();
   	
	$strEstId = $est_ref->GetStockId();
	$est_sql = $nav_sql;
	if ($est_sql->Count($strEstId) == 0 || $est_ref->IsIndex())
	{
		$est_sql = GetStockHistorySql();
	}

	$arDate = _getSwitchDateArray($nav_sql, $strStockId, $est_sql, $strEstId);
	if (count($arDate) == 0)		return;
 
 	$iIndex = 0;
    if ($result = $nav_sql->GetAll($strStockId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		$strNetValue = rtrim0($record['close']);
       		if ($strDate == $arDate[$iIndex])
       		{
   				$iIndex ++;
       			if ($csv)
       			{
       				if (isset($arDate[$iIndex]))
       				{
       					_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $nav_sql, $strStockId, $est_sql, $strEstId, $strInput, $bAdmin);
       				}
       				else
       				{
       					$csv->Write($strDate, $strNetValue);
       					break;
       				}
       			}
       			else
       			{
       				while (isset($arDate[$iIndex]))
       				{
       					_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $nav_sql, $strStockId, $est_sql, $strEstId, $strInput, $bAdmin);
       					$iIndex ++;
       				}
       				break;
       			}
       		}
       		else
       		{
       			if ($csv)	$csv->Write($strDate, $strNetValue);
       		}
        }
        @mysql_free_result($result);
    }
}

function _echoFundPositionParagraph($ref, $strSymbol, $strInput, $bAdmin)
{
   	$cny_ref = $ref->GetCnyRef();
	$est_ref = $ref->GetEstRef();
	
 	$str = GetFundLinks($strSymbol);
	$change_col = new TableColumnChange();
	$position_col = new TableColumnPosition();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnNav(),
								   $change_col,
								   new TableColumnUSCNY(),
								   $change_col,
								   new TableColumnNav($est_ref->GetSymbol()),
								   $change_col,
								   $position_col
								   ), 'fundposition', $str);
	
	if ($strInput == '0')
	{
		$csv = false;
		$strInput = POSITION_EST_LEVEL;
	}
	else
	{
		$csv = new PageCsvFile();
	}
	_echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput, $bAdmin);
	
    $str = '';
	if ($csv)
	{
		$csv->Close();
		if ($csv->HasFile())
		{
			$str .= '<br />'.$csv->GetLink();

			$jpg = new DateImageFile();
			if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))
			{
				$str .= '<br />'.$jpg->GetAll($position_col->GetDisplay(), $strSymbol);
			}

			$jpg2 = new DateImageFile(2);
			if ($jpg2->Draw($csv->ReadColumn(3), $csv->ReadColumn(1)))
			{
				$str .= '<br />&nbsp;<br />'.$jpg2->GetAll('对冲值', $strSymbol);
			}
		}
   	}
    EchoTableParagraphEnd($str);
}

function EchoAll()
{
	global $acct;
	
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strInput = SqlCleanString($_POST[EDIT_INPUT_NAME]);
	}
    else
    {
   		$strInput = POSITION_EST_LEVEL;
    }
    EchoEditInputForm('进行估算的涨跌阈值', $strInput);
    
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetSymbol();
        if (in_arrayQdii($strSymbol))
        {
            _echoFundPositionParagraph(new QdiiReference($strSymbol), $strSymbol, $strInput, $acct->IsAdmin());
        }
    }
    $acct->EchoLinks('fundposition');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_POSITION_DISPLAY;
    $str .= '。仅用于美股QDII基金，寻找对应ETF净值连续几天涨跌超过4%的机会测算A股基金的持仓仓位，LOF基金仓位可能会在80%-95%之间。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetSymbolDisplay().FUND_POSITION_DISPLAY;
}

    $acct = new SymbolAccount();
?>

