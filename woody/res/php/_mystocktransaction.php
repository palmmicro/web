<?php
require_once('_stock.php');
require_once('_idgroup.php');

function EchoAll()
{
	global $acct;
	
    if ($strGroupId = $acct->EchoStockGroup())
    {
        $arSymbol = SqlGetStocksArray($strGroupId, true);
        StockPrefetchArrayData($arSymbol);

        $strStockLinks = StockGetGroupTransactionLinks($strGroupId);
        if ($strSymbol = $acct->GetSymbol())
        {   // Display transactions of a stock
            $strAllLink = StockGetAllTransactionLink($strGroupId);
            EchoParagraph($strAllLink.' '.$strStockLinks);
           	EchoTransactionParagraph($acct, $strGroupId, new MyStockReference($strSymbol));
        }
        else
        {   // Display transactions of the whole group
            $strCombineLink = GetStockPhpLink('combinetransaction', '合并记录', 'groupid='.$strGroupId);
            EchoParagraph($strCombineLink.' '.$strStockLinks);
           	EchoTransactionParagraph($acct, $strGroupId);
        }
    }
    $acct->EchoLinks('transaction');
}

function GetTitle()
{
	global $acct;
    
   	$str = $acct->GetWhoseGroupDisplay().STOCK_GROUP_DISPLAY;
   	$str .= ($strSymbol = $acct->GetSymbol()) ? $strSymbol : '';
   	$str .= STOCK_TRANSACTION_DISPLAY.$acct->GetStartNumDisplay();
   	return $str;
}

function GetMetaDescription()
{
	$str = GetTitle();
    $str .= '管理页面。提供现有股票交易记录和编辑删除链接。主要用于某组股票交易记录超过一定数量后的显示，少量的股票交易记录一般直接显示在该股票页面而不是在这里。';
    return CheckMetaDescription($str);
}

class _TransAccount extends GroupIdAccount
{
	var $strSymbol;
	
    function _TransAccount() 
    {
        parent::GroupIdAccount();
        
        $this->strSymbol = StockCheckSymbol(UrlGetQueryValue('symbol'));
    }
    
    function GetSymbol()
    {
    	return $this->strSymbol;
    }
}

	$acct = new _TransAccount();
?>
