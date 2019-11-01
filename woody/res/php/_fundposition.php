<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/imagefile.php');

function _echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $strPrevDate, $sql, $cny_sql, $est_sql)
{
	$bWritten = false;
	$ar = array($strDate, $strNetValue);
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
			if ($strVal = LofGetStockPosition($strEstPrev, $strEst, $strPrev, $strNetValue, $strCnyPrev, $strCny))
			{
				$bWritten = true;
				$csv->Write($strDate, $strNetValue, $strVal);
				$ar[] = $strVal;
			}
		}
	}

	if ($bWritten == false)		$csv->Write($strDate, $strNetValue);
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
	
function _echoFundPositionData($csv, $ref, $cny_ref, $est_ref)
{
   	$sql = new NetValueHistorySql($ref->GetStockId());
	$est_sql = new NetValueHistorySql($est_ref->GetStockId());
	$cny_sql = new UscnyHistorySql();

	$arDate = _getSwitchDateArray($sql, $est_sql);
 //    DebugArray($arDate);
 
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
       			if (isset($arDate[$iIndex]))
       			{
       				_echoFundPositionItem($csv, $ref, $cny_ref, $est_ref, $strDate, $strNetValue, $arDate[$iIndex], $sql, $cny_sql, $est_sql);
       			}
       			else
       			{
       				$csv->Write($strDate, $strNetValue);
       				break;
       			}
       		}
       		else
       		{
       			$csv->Write($strDate, $strNetValue);
       		}
        }
        @mysql_free_result($result);
    }
}

function _echoFundPositionParagraph($ref, $cny_ref, $strSymbol)
{
	$est_ref = $ref->est_ref;
	
 	$str = GetFundLinks($strSymbol);
	$change_col = new TableColumnChange();
	$position_col = new TableColumnPosition();
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnNetValue(),
								   $change_col,
								   new TableColumnUSCNY(),
								   $change_col,
								   new TableColumnNetValue($est_ref->GetStockSymbol()),
								   $change_col,
								   $position_col
								   ), FUND_POSITION_PAGE, $str);
	
   	$csv = new PageCsvFile();
	_echoFundPositionData($csv, $ref, $cny_ref, $est_ref);
    $csv->Close();
	
    $str = '';
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
   		$jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1));
   		$str .= '<br />'.$csv->GetLink().'<br />'.$jpg->GetAll($position_col->GetDisplay(), $strSymbol);
   	}
    EchoTableParagraphEnd($str);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
        	$cny_ref = new CnyReference('USCNY');	// Always create CNY Forex class instance first!
            _echoFundPositionParagraph(new LofReference($strSymbol), $cny_ref, $strSymbol);
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

    $acct = new SymbolAcctStart(false);

?>

