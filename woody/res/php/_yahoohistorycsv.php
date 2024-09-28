<?php
require_once('../../php/csvfile.php');
require_once('../../php/stockhis.php');

class _YahooHistoryCsvFile extends DebugCsvFile
{
	var $strStockId;

	var $his_sql;
	var $oldest_ymd;
	
	var $iTotal;
	var $iModified;
	
	var $strLastDate;
	
    public function __construct($strFileName, $strStockId) 
    {
        parent::__construct($strFileName);
        
        $this->strStockId = $strStockId;
        $this->his_sql = GetStockHistorySql();
        $this->oldest_ymd = new OldestYMD();
        
        $this->iTotal = 0;
        $this->iModified = 0;
        
        $this->strLastDate = '';
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) < 7)						return;
    	
    	$strDate = $arWord[0];
    	if ($strDate == 'Date')						return;
   		if ($this->oldest_ymd->IsTooOld($strDate))	return;
    	if ($strDate == $this->strLastDate)		return;	// future have continue data 23 hours a day
    	$this->strLastDate = $strDate; 

    	// Date,Open,High,Low,Close,Adj Close,Volume        		
    	$strOpen = $arWord[1];
    	$strHigh = $arWord[2];
    	$strLow = $arWord[3];
    	$strClose = $arWord[4]; 
    	$strVolume = $arWord[6];
        if ($strClose == '-' || $strClose == 'null')
        {
        	DebugPrint($arWord);	// debug wrong data
        	return;
        }
        
        if ($strVolume == '0')
        {
        	if (($strClose == $strOpen) && ($strClose == $strHigh) && ($strClose == $strLow))
        	{
        		DebugString('Holiday: '.$strDate.' '.$strClose);
        		return;
        	}
        }
        
        if ($this->oldest_ymd->IsInvalid($strDate) == false)
        {
        	$this->iTotal ++;
        	if ($this->his_sql->WriteHistory($this->strStockId, $strDate, $strClose, $strOpen, $strHigh, $strLow, $strVolume, $arWord[5]))
        	{
//        		DebugString(implode(',', $arWord));
        		$this->iModified ++;
        	}
        }
	}
}

// https://query1.finance.yahoo.com/v7/finance/download/XOP?period1=1611853537&period2=1643389537&interval=1d&events=history&includeAdjustedClose=true
function YahooUpdateStockHistory($ref)
{
    $ref->SetTimeZone();
    $iEnd = GetNowTick(); 
	$strBegin = strval($iEnd - MAX_QUOTES_DAYS * SECONDS_IN_DAY);
//	$strEnd = strval($iEnd - $iEnd % SECONDS_IN_DAY + 18 * SECONDS_IN_HOUR - 1);
	$strEnd = strval($iEnd);
	$strYahooSymbol = $ref->GetYahooSymbol();
	$strUrl = GetYahooDataUrl('7')."/download/$strYahooSymbol?period1=$strBegin&period2=$strEnd&interval=1d&events=history&includeAdjustedClose=true";

	$strSymbol = $ref->GetSymbol();
	$strFileName = 'yahoohistory'.$strSymbol.'.csv';
	if (StockSaveDebugCsv($strFileName, $strUrl))
	{
		$csv = new _YahooHistoryCsvFile($strFileName, $ref->GetStockId());
		$csv->Read();

		DebugVal($csv->iTotal, 'Total');
		DebugVal($csv->iModified, 'Modified');
/*		if ($ref->IsSymbolA() || $ref->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
//			if ($ref->IsIndex() == false)
			{
				$csv->his_sql->DeleteByZeroVolume($strStockId);
			}
		}*/
		unlinkConfigFile($strSymbol);
	}
}

/*
// 1 - Get cookie
//https://stackoverflow.com/questions/76065035/yahoo-finance-v7-api-now-requiring-cookies-python
$url_yahoo = "https://fc.yahoo.com";
$yahoo_headers = get_headers($url_yahoo, true);
//print_r($yahoo_headers);
$cookie_name = 'Set-Cookie';

// 2 - Get crumb , setting cookie 
$url_yahoo2 = "https://query2.finance.yahoo.com/v1/test/getcrumb";
$c = curl_init($url_yahoo2);
curl_setopt($c, CURLOPT_VERBOSE, 1);
curl_setopt($c, CURLOPT_COOKIE, $yahoo_headers[$cookie_name]);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$crumb = curl_exec($c);
curl_close($c);
//echo "<BR>Crumb:" . $crumb;

// 3 - Get quotes with crumb, setting cookie. Using sample tickets
$tickets_list = "AAPL,TSLA";
$url_cotacao = "https://query2.finance.yahoo.com/v7/finance/quote?symbols=" . $tickets_list . "&crumb=" . $crumb;
$c = curl_init($url_cotacao);
curl_setopt($c, CURLOPT_VERBOSE, 1);
curl_setopt($c, CURLOPT_COOKIE, $yahoo_headers[$cookie_name]);
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
$data_quote = curl_exec($c);
curl_close($c);


// 4 - Get data from yahoo 
$resJson_decode = json_decode($data_quote, false);
if (!$resJson_decode->quoteResponse->result) {
    $resultado = "Ticket dont exists in yahoo!";
} else {
    foreach ($resJson_decode->quoteResponse->result as $ticket_result){
        echo "<BR>Ticket:" . $ticket_result->symbol;
        echo "<BR>Price:" . $ticket_result->regularMarketPrice;
    }
    
}
*/

?>
