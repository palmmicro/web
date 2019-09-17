<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');

class LinearRegression
{
    var $fA;
    var $fB;
    var $fR;

    function Mean($arF)
    {
    	$f = 0.0;
    	$iCount = count($arF);
    	if ($iCount > 0)
    	{
    		foreach ($arF as $fVal)
    		{
    			$f += $fVal;
    		}
    		$f /= $iCount;
    	}
    	return $f;
    }
    
    function SquareSum($arF)
    {
    	$f = 0.0;
    	foreach ($arF as $fVal)
    	{
    		$f += $fVal * $fVal;
    	}
    	return $f;
    }
    
    function LinearRegression($arX, $arY) 
    {
    	$iCount = count($arX);
    	$fMeanX = $this->Mean($arX);
    	DebugVal($fMeanX, 'Mean X');
    	$fMeanY = $this->Mean($arY);
    	DebugVal($fMeanY, 'Mean Y');
    	
    	$fSxx = $this->SquareSum($arX) - $iCount * $fMeanX * $fMeanX;
    	DebugVal($fSxx, 'Sxx');
    	$fSyy = $this->SquareSum($arY) - $iCount * $fMeanY * $fMeanY;
    	DebugVal($fSyy, 'Syy');
    	
    	$fSxy = 0.0;
    	foreach ($arX as $strKey => $fX)
    	{
    		$fSxy += $fX * $arY[$strKey];
    	}
    	$fSxy -= $iCount * $fMeanX * $fMeanY;
    	DebugVal($fSxy, 'Sxy');
    	
    	$this->fB = $fSxy / $fSxx;
    	DebugVal($this->fB, 'B');
    	$this->fA = $fMeanY - $this->fB * $fMeanX;
    	DebugVal($this->fA, 'A');
    	$this->fR = $fSxy / sqrt($fSxx) / sqrt($fSyy);
    	DebugVal($this->fR, 'R');
    }
}

function _echoFundAccountItem($csv, $strDate, $strSharesDiff, $ref, $nv_sql)
{
	$strClose = $ref->his_sql->GetClosePrev3($strDate);
	$strNetValue = $nv_sql->GetClosePrev4($strDate);
	$strPremium = $ref->GetPercentageDisplay($strNetValue, $strClose);
	$fAccount = floatval($strSharesDiff) * 10000.0 / (985.0 / floatval($nv_sql->GetClosePrev3($strDate)));
	$strAccount = strval(intval($fAccount));

   	$csv->Write($strDate, $strSharesDiff, $strAccount, $strClose, $strNetValue, $ref->GetPercentage($strNetValue, $strClose));
	
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strSharesDiff</td>
        <td class=c1>$strAccount</td>
        <td class=c1>-></td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
    </tr>
END;
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
 	$str = GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);
	if ($bAdmin)
	{
		$str .= ' '.GetStockOptionLink(STOCK_OPTION_SHARES_DIFF, $strSymbol);
	}
	
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumn(STOCK_OPTION_SHARES_DIFF, 110),
								   new TableColumn('场内申购账户', 100),
								   new TableColumn('场内申购日->', 100),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium()
								   ), 'fundaccount', $str);
	
	_echoFundAccountData($csv, $ref);
    EchoTableParagraphEnd();
}

function _echoLinearRegressionParagraph($csv)
{
	$arX = $csv->ReadColumn(5);
	$arY = $csv->ReadColumn(2);
	$lr = new LinearRegression($arX, $arY);
	
	$str = $csv->GetLink();
	$str .= ' '.strval(intval($lr->fA)).' '.strval(intval($lr->fB)).' '.strval($lr->fR);
    EchoParagraph($str);
}

function EchoAll()
{
	global $group;
	
	$bAdmin = $group->IsAdmin();
    if ($ref = $group->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
        	$csv = new PageCsvFile();
            _echoFundAccountParagraph($csv, $ref, $strSymbol, $bAdmin);
            if ($csv->HasFile())
            {
            	_echoLinearRegressionParagraph($csv);
            }
        }
    }
    $group->EchoLinks();
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().FUND_ACCOUNT_DISPLAY;
    $str .= '. 仅用于华宝油气(SZ162411)等LOF基金. 利用2019年8月开始华宝油气限购1000块人民币的机会测算A股LOF溢价申购套利的群体规模. 充分了解交易对手, 做到知己知彼百战不殆.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().FUND_ACCOUNT_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage(false);

?>

