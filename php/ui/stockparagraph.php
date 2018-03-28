<?php

function EchoReferenceParagraph($arRef, $bChinese)
{
    if ($bChinese)     
    {
        $str = '参考数据';
    }
    else
    {
        $str = 'Reference data';
    }
    
    EchoParagraphBegin($str);
    EchoReferenceTable($arRef, $bChinese);
    EchoParagraphEnd();
}

function EchoStockTransactionParagraph($strGroupId, $ref, $result, $bChinese)
{
    if ($result == false)   return;
    
    $strGroupLink = SelectGroupInternalLink($strGroupId, $bChinese);
    $strAllLink = StockGetAllTransactionLink($strGroupId, $ref->GetStockSymbol(), $bChinese);
    EchoParagraphBegin($strGroupLink.' '.$strAllLink);
    EchoStockTransactionTable($strGroupId, $ref, $result, $bChinese);
    EchoParagraphEnd();
}

?>
