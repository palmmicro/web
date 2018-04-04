<?php
require_once('/php/stock.php');
//require_once('/php/gb2312.php');            // FromGB2312ToUTF8
require_once('/php/ui/table.php');
require_once('/php/ui/referenceparagraph.php');     // EchoReferenceTable

function EchoStockPrice($bChinese)
{
    if ($bChinese)
    {
        $ref = new SinaStockReference('ACTS');
//        $ref->strDescription = FromGB2312ToUTF8($ref->strChineseName);
    }
    else
    {
        $ref = new YahooStockReference('ACTS');
        $ref->strDescription = $ref->strName;
    }
    EchoReferenceTable(array($ref), $bChinese);
    echo '<br />'.$ref->GetDebugLink();
}


?>
