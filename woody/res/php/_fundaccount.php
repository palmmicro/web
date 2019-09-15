<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');

function _echoFundAccountItem($csv, $strDate, $strSharesDiff, $ref)
{
	$strClose = '';
	$strNetValue = '';
	$strPremium = '';
	
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strSharesDiff</td>
        <td class=c1>-></td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPremium</td>
    </tr>
END;
}

function _echoFundAccountData($ref)
{
	$strStockId = $ref->GetStockId();
	$sql = new EtfSharesDiffSql($strStockId);
    if ($result = $sql->GetAll()) 
    {
     	$csv = new PageCsvFile();
        while ($record = mysql_fetch_assoc($result)) 
        {
       		$strDate = $record['date'];
       		_echoFundAccountItem($csv, $strDate, rtrim0($record['close']), $ref);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoFundAccountParagraph($ref, $strSymbol, $bAdmin)
{
 	$str = GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);
	if ($bAdmin)
	{
		$str .= ' '.GetStockOptionLink(STOCK_OPTION_SHARES_DIFF, $strSymbol);
	}
	
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumn(STOCK_OPTION_SHARES_DIFF, 110),
								   new TableColumn('场内申购日->', 110),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium()
								   ), 'fundaccount', $str);
	
	_echoFundAccountData($ref);
    EchoTableParagraphEnd();
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
            _echoFundAccountParagraph($ref, $strSymbol, $bAdmin);
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

