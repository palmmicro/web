<?php
require_once('_stock.php');
require_once('_stockgroup.php');
require_once('_fundgroup.php');

class _GoldEtfAccount extends FundGroupAccount
{
    function _GoldEtfAccount() 
    {
        parent::FundGroupAccount();
        $strSymbol = $this->GetName();
        
        StockPrefetchData($strSymbol);
        GetChinaMoney();

        $this->cny_ref = new CnyReference('USCNY');
        $this->ref = new GoldFundReference($strSymbol);
        
        $this->CreateGroup(array($this->ref->stock_ref));
    }
} 

function _echoTestParagraph($acct)
{
	$fund = $acct->GetRef();
    $str = _GetEtfAdjustString($fund->stock_ref, $fund->GetEstRef());
    EchoParagraph($str);
}

function EchoAll()
{
    global $acct;

	$fund = $acct->GetRef();
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array($fund->GetEstRef(), $fund->future_ref, $acct->cny_ref, $fund->stock_ref));
    EchoFundTradingParagraph($fund);    
    EchoFundHistoryParagraph($fund);

    if ($group = $acct->EchoTransaction()) 
    {
    	EchoMoneyParagraph($group, $acct->cny_ref->GetPrice());
	}
    
    _echoTestParagraph($acct);
    $acct->EchoLinks('goldetf', 'GetGoldEtfRelated');
}

function GetGoldEtfLinks($sym)
{
	$str = GetJisiluGoldLink();

	$str .= '<br />&nbsp';
	
	$str .= GetGoldSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	return $str;
}

function EchoMetaDescription()
{
    global $acct;

	$fund = $acct->GetRef();
    $strDescription = RefGetStockDisplay($fund->stock_ref);
    $strEst = RefGetStockDisplay($fund->GetEstRef());
    $strFuture = RefGetStockDisplay($fund->future_ref);
    $strCNY = RefGetStockDisplay($acct->cny_ref);
    $str = '根据'.$strEst.', '.$strFuture.'和'.$strCNY.'等因素计算'.$strDescription.'净值的网页工具.';
    EchoMetaDescriptionText($str);
}

   	$acct = new _GoldEtfAccount();
?>
