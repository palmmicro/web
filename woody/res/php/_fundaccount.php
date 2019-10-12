<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function SquareSum($arF)
{
  	$f = 0.0;
   	foreach ($arF as $fVal)
   	{
   		$f += pow($fVal, 2);
   	}
   	return $f;
}
    
function LinearRegression($arX, $arY)
{
   	$iCount = count($arX);
   	$fMeanX = array_sum($arX) / $iCount;
   	$fMeanY = array_sum($arY) / $iCount;
    	
   	$fSxx = SquareSum($arX) - $iCount * pow($fMeanX, 2);
   	$fSyy = SquareSum($arY) - $iCount * pow($fMeanY, 2);
    	
   	$fSxy = 0.0;
   	foreach ($arX as $strKey => $fX)
   	{
   		$fSxy += $fX * $arY[$strKey];
   	}
   	$fSxy -= $iCount * $fMeanX * $fMeanY;
    	
   	$fB = $fSxy / $fSxx;
   	$fA = $fMeanY - $fB * $fMeanX;
    $fR = $fSxy / sqrt($fSxx) / sqrt($fSyy);
	return array($fA, $fB, $fR);
}

function _echoFundAccountItem($csv, $strDate, $strSharesDiff, $ref, $nv_sql)
{
    $iCount = 0;
    $his_sql = $ref->GetHistorySql();
    if ($result = $his_sql->GetFromDate($strDate, 5)) 
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
    
	$strPurchaseValue = $nv_sql->GetClose($strPurchaseDate);
	$fAccount = floatval($strSharesDiff) * 10000.0 / (985.0 / floatval($strPurchaseValue));
	$strAccount = strval(intval($fAccount));

   	$ar = array($strDate, $strSharesDiff, $strAccount, $strPurchaseDate);
    if ($strPurchaseDate == GetNextTradingDayYMD($strNetValueDate))
    {
    	$strNetValue = $nv_sql->GetClose($strNetValueDate);
    	
    	$ar[] = $ref->GetPriceDisplay($strClose, $strNetValue);
    	$ar[] = $strNetValue;
    	$ar[] = $ref->GetPercentageDisplay($strNetValue, $strClose);
    	$csv->Write($strDate, $strSharesDiff, $strAccount, $strClose, $strNetValue, $ref->GetPercentage($strNetValue, $strClose));
    }
	
	EchoTableColumn($ar);
}

function _echoFundAccountData($csv, $ref)
{
	$strStockId = $ref->GetStockId();
	$nv_sql = new NetValueHistorySql($strStockId);
	
	$sql = new EtfSharesDiffSql($strStockId);
    if ($result = $sql->GetAll()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		_echoFundAccountItem($csv, $strDate, rtrim0($record['close']), $ref, $nv_sql);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoFundAccountParagraph($csv, $ref, $strSymbol, $bAdmin)
{
 	$str = GetFundLinks($strSymbol);
	if ($bAdmin)
	{
		$str .= ' '.GetStockOptionLink(STOCK_OPTION_SHARES_DIFF, $strSymbol);
	}
	
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumn(STOCK_OPTION_SHARES_DIFF, 110),
								   new TableColumn(STOCK_DISP_ACCOUNT, 100),
								   new TableColumnDate('场内申购'),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium()
								   ), FUND_ACCOUNT_PAGE, $str);
	
	_echoFundAccountData($csv, $ref);
    EchoTableParagraphEnd();
}

function _echoLinearRegressionGraph($csv)
{
	$arX = $csv->ReadColumn(5);
	$arY = $csv->ReadColumn(2);
	list($fA, $fB, $fR) = LinearRegression($arX, $arY);
	
	$str = $csv->GetLink();
	$str .= '<br />Y('.STOCK_DISP_ACCOUNT.') = '.strval(intval($fA)).' + '.strval(intval($fB)).' * X('.STOCK_DISP_PREMIUM.'); r =  '.strval_round($fR);
//    EchoParagraph($str);

    $jpg = new LinearImageFile();
    $jpg->Draw($arX, $arY, $fA, $fB);
    $jpg->EchoFile($str);
}

function EchoAll()
{
	global $acct;
	
	$bAdmin = $acct->IsAdmin();
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
        	$csv = new PageCsvFile();
            _echoFundAccountParagraph($csv, $ref, $strSymbol, $bAdmin);
            if ($csv->HasFile())
            {
            	_echoLinearRegressionGraph($csv);
            }
            
            EchoRemarks($strSymbol);
        }
    }
    $acct->EchoLinks(FUND_ACCOUNT_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_ACCOUNT_DISPLAY;
    $str .= '. 仅用于华宝油气(SZ162411)等LOF基金. 利用2019年8月开始华宝油气限购1000块人民币的机会测算A股LOF溢价申购套利的群体规模. 充分了解交易对手, 做到知己知彼百战不殆.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().FUND_ACCOUNT_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart(false);

?>

