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

        if ($strSymbol = $acct->GetSymbol())
        {   // Display transactions of a stock
            $strAllLink = StockGetAllTransactionLink($strGroupId);
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId, $strSymbol);
            EchoParagraph($strAllLink.' '.$strStockLinks);
           	EchoTransactionParagraph($acct, $strGroupId, new MyStockReference($strSymbol));
        }
        else
        {   // Display transactions of the whole group
            $strCombineLink = GetPhpLink(STOCK_PATH.'combinetransaction', 'groupid='.$strGroupId, '合并记录');
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId);
            EchoParagraph($strCombineLink.' '.$strStockLinks);
           	EchoTransactionParagraph($acct, $strGroupId);
        }
    }
    $acct->EchoLinks('transaction');
}

function EchoMetaDescription()
{
	global $acct;
	
	$str = $acct->GetDescription();
    $str .= '管理页面. 提供现有股票交易记录和编辑删除链接, 主要用于某组股票交易记录超过一定数量后的显示. 少量的股票交易记录一般直接显示在该股票页面而不是在这里.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
	echo $acct->GetDescription();
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
    
    function GetDescription()
    {
    	$str = $this->GetWhoseGroupDisplay().STOCK_GROUP_DISPLAY;
    	$str .= ($this->strSymbol) ? $this->strSymbol : STOCK_DISP_ALL;
    	$str .= '交易记录';
    	return $str;
    }
}

	$acct = new _TransAccount();
?>
