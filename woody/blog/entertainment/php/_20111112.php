<?php
require_once('/php/account.php');					// AcctSessionStart
require_once('/php/gb2312.php');            		// FromGB2312ToUTF8 used in stockref.php
require_once('/php/stock.php');
require_once('/php/ui/referenceparagraph.php');     // EchoReferenceTable

function EchoStockPrice($bChinese)
{
	AcctSessionStart();
   
	if ($bChinese)
    {
        $ref = new SinaStockReference('ACTS');
        $ref->strDescription = $ref->GetChineseName();
    }
    else
    {
        $ref = new YahooStockReference('ACTS');
        $ref->strDescription = $ref->GetEnglishName();
    }
    EchoReferenceTable(array($ref), $bChinese);
    echo '<br />'.$ref->DebugLink();
}


?>
