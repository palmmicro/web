<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');

function _echoFundAccountParagraph($strSymbol)
{
 	$str = GetNetValueHistoryLink($strSymbol).' '.GetStockHistoryLink($strSymbol);
	EchoTableParagraphBegin(array(new TableColumnDate(),
								   new TableColumnClose(),
								   new TableColumnNetValue(),
								   new TableColumnPremium()
								   ), 'fundaccount', $str);
	
    EchoTableParagraphEnd();
}

function EchoAll()
{
	global $group;
	
    if ($ref = $group->EchoStockGroup())
    {
   		$strSymbol = $ref->GetStockSymbol();
        if (in_arrayLof($strSymbol))
        {
            _echoFundAccountParagraph($strSymbol);
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

