<?php
require_once('_stock.php');

// ****************************** Public *******************************************************

function MyStockTransactionEchoAll($bChinese)
{
    global $g_strGroupId;
    global $g_strSymbol;
    
    if ($g_strGroupId)
    {
        $iStart = UrlGetQueryInt('start', 0);
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        $strGroupLink = _GetReturnGroupLink($g_strGroupId, $bChinese);
        
        if ($g_strSymbol)
        {   // Display transactions of a stock
            $strAllLink = StockGetAllTransactionLink($g_strGroupId, false, $bChinese);
            $strStockLinks = StockGetGroupTransactionLinks($g_strGroupId, $g_strSymbol, $bChinese);
            
            $ref = new MyStockReference($g_strSymbol);
            $strStockId = $ref->strSqlId;
            $iTotal = SqlCountStockTransaction($g_strGroupId, $strStockId);
            $strNavLink = _GetNavLink('mystocktransaction', 'groupid='.$g_strGroupId.'&symbol='.$g_strSymbol, $iTotal, $iStart, $iNum, $bChinese);
            
            EchoParagraphBegin($strGroupLink.' '.$strAllLink.' '.$strStockLinks.'<br />'.$strNavLink);
            if ($result = SqlGetStockTransaction($g_strGroupId, $strStockId, $iStart, $iNum)) 
            {
                EchoStockTransactionTable($g_strGroupId, $ref, $result, $bChinese);
            }
        }
        else
        {   // Display transactions of the whole group
            $arSymbol = SqlGetStockGroupPrefetchSymbolArray($g_strGroupId);
            PrefetchForexAndStockData($arSymbol);
            
            $strCombineLink = _GetCombineTransactionLink($g_strGroupId, $bChinese);
            $strStockLinks = StockGetGroupTransactionLinks($g_strGroupId, '', $bChinese);
            
            $iTotal = SqlCountStockTransactionByGroupId($g_strGroupId);
            $strNavLink = _GetNavLink('mystocktransaction', 'groupid='.$g_strGroupId, $iTotal, $iStart, $iNum, $bChinese);
            EchoParagraphBegin($strGroupLink.' '.$strCombineLink.' '.$strStockLinks.'<br />'.$strNavLink);
            
            $group = new MyStockGroup($g_strGroupId, array());
            _EchoTransactionTable($group, $iStart, $iNum, $bChinese);
        }
        EchoParagraphEnd();
    }
    EchoPromotionHead('transaction', $bChinese);
}

function MyStockTransactionEchoMetaDescription($bChinese)
{
    global $g_strGroupId;
    global $g_strSymbol;
    
    $str = _GetWhoseStockGroupDisplay(false, $g_strGroupId, $bChinese);
    $strStock = _GetAllDisplay($g_strSymbol, $bChinese);
    if ($bChinese)  $str .= '股票分组'.$strStock.'交易记录管理页面. 提供现有股票交易记录和编辑删除链接, 主要用于某组股票交易记录超过一定数量后的显示. 少量的股票交易记录一般直接显示在该股票页面而不是在这里.';
    else             $str .= ' stock group '.$strStock.' transactions management, provide edit and delete links. Usually used when transaction records over a certain number.';
    EchoMetaDescriptionText($str);
}

function MyStockTransactionEchoTitle($bChinese)
{
    global $g_strMemberId;
    global $g_strGroupId;
    global $g_strSymbol;
    
    $str = _GetWhoseStockGroupDisplay($g_strMemberId, $g_strGroupId, $bChinese);
    $strStock = _GetAllDisplay($g_strSymbol, $bChinese);
    if ($bChinese)  $str .= '股票分组'.$strStock.'交易记录';
    else             $str .= ' Stock Group '.$strStock.' Transactions';
    echo $str;
}

    $g_strMemberId = AcctNoAuth();
    $g_strGroupId = UrlGetQueryValue('groupid');
    $g_strSymbol = UrlGetQueryValue('symbol');

?>

