<?php
require_once('_stock.php');

function MyStockTransactionEchoAll($bChinese)
{
    if ($strGroupId = UrlGetQueryValue('groupid'))
    {
        $iStart = UrlGetQueryInt('start', 0);
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        $strGroupLink = _GetReturnGroupLink($strGroupId, $bChinese);
        
        if ($strSymbol = UrlGetQueryValue('symbol'))
        {   // Display transactions of a stock
            $strAllLink = StockGetAllTransactionLink($strGroupId, false, $bChinese);
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId, $strSymbol, $bChinese);
            EchoParagraph($strGroupLink.' '.$strAllLink.' '.$strStockLinks);
            
            $ref = new MyStockReference($strSymbol);
            $iTotal = SqlCountStockTransaction($strGroupId, $ref->GetStockId());
            if ($iTotal > 0)
            {
            	$strNavLink = GetNavLink('groupid='.$strGroupId.'&symbol='.$strSymbol, $iTotal, $iStart, $iNum, $bChinese);
            	EchoTransactionFullParagraph($strNavLink, $strGroupId, $ref, $iStart, $iNum, $bChinese);
            }
        }
        else
        {   // Display transactions of the whole group
            $arSymbol = SqlGetStockGroupPrefetchSymbolArray($strGroupId);
            StockPrefetchData($arSymbol);
            
            $strCombineLink = BuildPhpLink(STOCK_PATH.'combinetransaction', 'groupid='.$strGroupId, '合并记录', 'Combined Records', $bChinese);
            $strStockLinks = StockGetGroupTransactionLinks($strGroupId, '', $bChinese);
            EchoParagraph($strGroupLink.' '.$strCombineLink.' '.$strStockLinks);
            
            $iTotal = SqlCountStockTransactionByGroupId($strGroupId);
            if ($iTotal > 0)
            {
            	$strNavLink = GetNavLink('groupid='.$strGroupId, $iTotal, $iStart, $iNum, $bChinese);
            	EchoTransactionFullParagraph($strNavLink, $strGroupId, false, $iStart, $iNum, $bChinese);
            }
        }
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

