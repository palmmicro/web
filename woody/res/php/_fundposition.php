<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/dateimagefile.php');
require_once('/php/ui/editinputform.php');

function _echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $strPrevDate, $sql, $cny_sql, $est_sql, $strInput)
{
	$bWritten = false;
	$ar = array();
	$ar[] = $csv ? $strDate : $strPrevDate;
	$ar[] = $strNetValue;
	
   	$strPrev = $sql->GetClose($strPrevDate);
	$ar[] = $ref->GetPercentageDisplay($strPrev, $strNetValue);

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
			if ($strPosition = QdiiGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny, $strInput))
			{
				$bWritten = true;
				$strCalibration = QdiiGetStockCalibration($strEst, $strNetValue, $strCny, $strPosition);
				if ($csv)	$csv->Write($strDate, $strNetValue, $strPosition, $strCalibration);
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

function _getSwitchDateArray($sql, $est_sql)
{
	$arDate = array();
	$bFirst = true;
    if ($result = $sql->GetAll()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		if ($strEst = $est_sql->GetClose($strDate))
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
	
function _echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput)
{
	$strEstId = $est_ref->GetStockId();
	$est_sql = new NetValueHistorySql($strEstId);
	if ($est_sql->Count() == 0)
	{
		$est_sql = new StockHistorySql($strEstId);
	}

   	$sql = new NetValueHistorySql($ref->GetStockId());
	$arDate = _getSwitchDateArray($sql, $est_sql);
	if (count($arDate) == 0)		return;
 
	$cny_sql = new UscnyHistorySql();
 	$iIndex = 0;
    if ($result = $sql->GetAll()) 
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
       					_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $sql, $cny_sql, $est_sql, $strInput);
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
       					_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $sql, $cny_sql, $est_sql, $strInput);
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

function _echoFundPositionParagraph($ref, $cny_ref, $strSymbol, $strInput)
{
	$est_ref = $ref->GetEstRef();
	
 	$str = GetFundLinks($strSymbol);
	$change_col = new TableColumnChange();
	$position_col = new TableColumnPosition();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnNetValue(),
								   $change_col,
								   new TableColumnUSCNY(),
								   $change_col,
								   new TableColumnNetValue($est_ref->GetSymbol()),
								   $change_col,
								   $position_col
								   ), FUND_POSITION_PAGE, $str);
	
	if ($strInput == '0')
	{
		$csv = false;
		$strInput = POSITION_EST_LEVEL;
	}
	else
	{
		$csv = new PageCsvFile();
	}
	_echoFundPositionData($csv, $ref, $cny_ref, $est_ref, $strInput);
	
    $str = '';
	if ($csv)
	{
		$csv->Close();
		if ($csv->HasFile())
		{
			$str .= '<br />'.$csv->GetLink();

			$jpg = new DateImageFile();
			$jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1));
			$str .= '<br />'.$jpg->GetAll($position_col->GetDisplay(), $strSymbol);

			$jpg2 = new DateImageFile(2);
			$jpg2->Draw($csv->ReadColumn(3), $csv->ReadColumn(1));
			$str .= '<br />&nbsp;<br />'.$jpg2->GetAll('对冲值', $strSymbol);
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
        	$cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
            _echoFundPositionParagraph(new QdiiReference($strSymbol), $cny_ref, $strSymbol, $strInput);
        }
    }
    $acct->EchoLinks(FUND_POSITION_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_POSITION_DISPLAY;
    $str .= '. 仅用于华宝油气(SZ162411)等LOF基金. 寻找XOP净值连续几天上涨或者下跌超过4%的机会测算华宝油气的股票持仓仓位, 按基金说明书这个数值可能会在80%-95%之间变动.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().FUND_POSITION_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

