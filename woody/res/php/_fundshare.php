<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('../../php/stock/szse.php');
require_once('../../php/ui/fundshareparagraph.php');

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
        SzseGetLofShares($ref);
        EchoFundShareParagraph($ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks('fundshare');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(FUND_SHARE_DISPLAY);
    $str .= '。显示基金场内份额、当日新增和当日成交量等相关信息。主要用来判断当日新增份额的套利党出货情况。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(FUND_SHARE_DISPLAY);
}

    $acct = new SymbolAccount();
?>

