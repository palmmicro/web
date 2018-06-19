<?php
require_once('_stock.php');

function MyStockTransactionEchoAll($bChinese = true)
{
    if ($strGroupId = UrlGetQueryValue('groupid'))
    {
        $iStart = UrlGetQueryInt('start');
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        $strGroupLink = _GetReturnGroupLink($strGroupId, $bChinese);
        
        if ($strSymbol = UrlGetQueryValue('symbol'))
        {   // Display transactions of a stock
            $strAllLink = StockGetAllTransactionLink($strGroupId, $bChinese);
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId, $bChinese, $strSymbol);
            EchoParagraph($strGroupLink.' '.$strAllLink.' '.$strStockLinks);
           	EchoTransactionParagraph($strGroupId, $bChinese, new MyStockReference($strSymbol), $iStart, $iNum);
        }
        else
        {   // Display transactions of the whole group
            $arSymbol = SqlGetStocksArray($strGroupId, true);
            StockPrefetchArrayData($arSymbol);
            
            $strCombineLink = GetPhpLink(STOCK_PATH.'combinetransaction', $bChinese, '合并记录', 'Combined Records', 'groupid='.$strGroupId);
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId, $bChinese);
            EchoParagraph($strGroupLink.' '.$strCombineLink.' '.$strStockLinks);
           	EchoTransactionParagraph($strGroupId, $bChinese, false, $iStart, $iNum);
        }
    }
    EchoPromotionHead($bChinese, 'transaction');
}

function MyStockTransactionEchoMetaDescription($bChinese = true)
{
    $str = _GetWhoseStockGroupDisplay(false, UrlGetQueryValue('groupid'), $bChinese);
    $strStock = _GetAllDisplay(UrlGetQueryValue('symbol'), $bChinese);
    if ($bChinese)  $str .= '股票分组'.$strStock.'交易记录管理页面. 提供现有股票交易记录和编辑删除链接, 主要用于某组股票交易记录超过一定数量后的显示. 少量的股票交易记录一般直接显示在该股票页面而不是在这里.';
    else             $str .= ' stock group '.$strStock.' transactions management, with edit and delete links and various data analysis tools.';
    EchoMetaDescriptionText($str);
}

function MyStockTransactionEchoTitle($bChinese = true)
{
    $str = _GetWhoseStockGroupDisplay(AcctIsLogin(), UrlGetQueryValue('groupid'), $bChinese);
    $strStock = _GetAllDisplay(UrlGetQueryValue('symbol'), $bChinese);
    if ($bChinese)  $str .= '股票分组'.$strStock.'交易记录';
    else             $str .= ' Stock Group '.$strStock.' Transactions';
    echo $str;
}

    AcctAuth();

?>

