<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/linearimagefile.php');

function _getFundAmount($strSymbol, $strDate)
{
	$iTick = strtotime($strDate);
	switch ($strSymbol)
	{
	case 'SH501018':
		return 2000.0 * 0.988;
		
	case 'SZ160216':
		return 10000.0;
		
	case 'SZ160416':
		if ($iTick >= strtotime('2020-10-27'))
		{
			return 2000.0;
		}
		else if ($iTick >= strtotime('2020-09-11'))
		{
			return 1000.0;
		}
		return 10000.0;
		
	case 'SZ162411':
		if ($iTick >= strtotime('2020-07-14'))
		{
			$iAmount = 100;
		}
		else
		{
			$iAmount = 1000;
		}
		return $iAmount * 0.985;
		
	case 'SZ162719':
		if ($iTick >= strtotime('2020-08-06'))
		{
			$iAmount = 500;
		}
		else
		{
			$iAmount = 1000;
		}
		return $iAmount * 0.988;

	case 'SZ164906':
		if ($iTick >= strtotime('2021-11-30'))
		{
			$iAmount = 1000;
		}
		else
		{
			$iAmount = 5000;
		}
		return $iAmount * 0.988;
	}
	return 500.0 * 0.988;	// SZ161127
}

function _echoFundAccountItem($csv, $strDate, $strSharesDiff, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql)
{
    $iCount = 0;
    if ($result = $his_sql->GetFromDate($strStockId, $strDate, 5)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if ($iCount == 3)
            {
            	$strClose = rtrim0($record['close']);
            	$strPurchaseDate = $record['date'];
            }
            else if ($iCount == 4)
            {
            	$strNetValueDate = $record['date'];
            }
            
            $iCount ++;
        }
        @mysql_free_result($result);
    }

   	$ar = array($strDate, $strSharesDiff);
    if ($iCount == 5)
    {
    	$fPurchaseValue = floatval($nav_sql->GetClose($strStockId, $strPurchaseDate));
       	$fAmount = _getFundAmount($strSymbol, $strPurchaseDate);
    	$fAccount = floatval($strSharesDiff) * 10000.0 / ($fAmount / $fPurchaseValue);
    	$strAccount = strval(intval($fAccount));
    	$ar[] = ($fAccount > MIN_FLOAT_VAL) ? $strAccount : '';
    	$ar[] = $strPurchaseDate;
    	
    	if ($strPurchaseDate == GetNextTradingDayYMD($strNetValueDate))
    	{
    		$strNetValue = $nav_sql->GetClose($strStockId, $strNetValueDate);
    	
    		$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
    		$ar[] = $strNetValue;
    		$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);
    		if ($fAccount > MIN_FLOAT_VAL && $ref->GetPercentage($strNetValue, $strClose) > MIN_FLOAT_VAL)
    		{	// 平价和折价数据不参与线性回归
    			$csv->Write($strDate, $strSharesDiff, $strAccount, $strClose, $strNetValue, $ref->GetPercentageString($strNetValue, $strClose));
    		}
    	}
    	else
    	{
    		$ar[] = $strClose;
    	}
    }
	
	EchoTableColumn($ar);
}

function _echoFundAccountData($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql)
{
	$sql = new SharesDiffSql();
    if ($result = $sql->GetAll($strStockId)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		_echoFundAccountItem($csv, $strDate, rtrim0($record['close']), $ref, $strSymbol, $strStockId, $his_sql, $nav_sql);
        }
        @mysql_free_result($result);
    }
}

function _getFundAccountTableColumnArray()
{
	return array(new TableColumnDate(),
				   new TableColumn(STOCK_OPTION_SHARE_DIFF, 110),
				   new TableColumn('y'.STOCK_DISP_ORDER.'账户', 90),
				   new TableColumnDate(STOCK_DISP_ORDER),
				   new TableColumnClose(),
				   new TableColumnNetValue(),
				   new TableColumnPremium('x')
				   );
}

function _echoFundAccountParagraph($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql, $bAdmin)
{
 	$str = GetFundLinks($strSymbol);
	if ($bAdmin)
	{
		$str .= ' '.GetStockOptionLink(STOCK_OPTION_SHARE_DIFF, $strSymbol);
	}
	
	EchoTableParagraphBegin(_getFundAccountTableColumnArray(), FUND_ACCOUNT_PAGE, $str);
	_echoFundAccountData($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql);
    EchoTableParagraphEnd();
}

function _echoFundAccountPredictData($ref, $strSymbol, $strStockId, $his_sql, $nav_sql, $jpg)
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
    $now_ymd = new NowYMD();

    $iCount = 0;
    if ($result = $his_sql->GetFromDate($strStockId, $now_ymd->GetYMD(), 4)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	if ($iCount == 0)
        	{
        		$strDate = GetNextTradingDayYMD($record['date']);
        	}
            else if ($iCount == 2)
            {
            	$strClose = rtrim0($record['close']);
            	$strPurchaseDate = $record['date'];
            }
            else if ($iCount == 3)
            {
            	$strNetValueDate = $record['date'];
            }
            
            $iCount ++;
        }
        @mysql_free_result($result);
    }
    
   	$ar = array($strDate);
   	if ($iCount == 4)
   	{
   		if ($strPurchaseDate == GetNextTradingDayYMD($strNetValueDate))
   		{
   			$fPurchaseValue = floatval($nav_sql->GetClose($strStockId, $strPurchaseDate));
   			$strNetValue = $nav_sql->GetClose($strStockId, $strNetValueDate);
   			$fAccount = $jpg->GetY($ref->GetPercentage($strNetValue, $strClose));
   			$fAmount = _getFundAmount($strSymbol, $strPurchaseDate);
   			$fSharesDiff = ($fPurchaseValue == 0.0) ? 0.0 : $fAccount * ($fAmount / $fPurchaseValue) / 10000.0;
   			$ar[] = intval($fSharesDiff);
   			$ar[] = intval($fAccount);
    		$ar[] = $strPurchaseDate;
    		$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
    		$ar[] = $strNetValue;
    		$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);
    	}
    	else
    	{
    		$ar[] = '';
    		$ar[] = '';
    		$ar[] = $strPurchaseDate;
    		$ar[] = $strClose;
    	}
    }
	
	EchoTableColumn($ar);
}

function _echoLinearRegressionGraph($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql)
{
    $jpg = new LinearImageFile();
    if ($jpg->Draw($csv->ReadColumn(5), $csv->ReadColumn(2)))
    {
    	$str = $csv->GetLink();
    	$str .= '<br />'.$jpg->GetAllLinks();
    	$str .= '<br />下一交易日'.STOCK_OPTION_SHARE_DIFF.'预测';

    	EchoTableParagraphBegin(_getFundAccountTableColumnArray(), 'predict'.FUND_ACCOUNT_PAGE, $str);
    	_echoFundAccountPredictData($ref, $strSymbol, $strStockId, $his_sql, $nav_sql, $jpg);
    	EchoTableParagraphEnd();
    }
}

function EchoAll()
{
	global $acct;
	
	$bAdmin = $acct->IsAdmin();
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetSymbol();
        if (in_arrayQdii($strSymbol))
        {
        	$strStockId = $ref->GetStockId();
        	$nav_sql = GetNavHistorySql();
        	$his_sql = GetStockHistorySql();
        	
        	$csv = new PageCsvFile();
            _echoFundAccountParagraph($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql, $bAdmin);
            $csv->Close();
            if ($csv->HasFile())
            {
            	_echoLinearRegressionGraph($csv, $ref, $strSymbol, $strStockId, $his_sql, $nav_sql);
            }
            
            EchoRemarks($strSymbol);
        }
    }
    $acct->EchoLinks(FUND_ACCOUNT_PAGE);
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_ACCOUNT_DISPLAY;
    $str .= '。仅用于美股相关QDII基金，利用A股基金限购的机会测算QDII溢价申购套利的群体规模。充分了解交易对手，做到知己知彼百战不殆。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetSymbolDisplay().FUND_ACCOUNT_DISPLAY;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

