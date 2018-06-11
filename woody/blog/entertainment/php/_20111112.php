<?php
require_once('/php/stock.php');
require_once('/php/stock/sinastockref.php');
require_once('/php/ui/referenceparagraph.php');

function EchoStockPrice($bChinese)
{
    $ref = new SinaStockReference('IQ');
	if ($bChinese)
    {
        $ref->strDescription = $ref->GetChineseName();
    }
    else
    {
        $ref->strDescription = $ref->GetEnglishName();
    }
    EchoReferenceParagraph(array($ref), $bChinese, $ref->DebugLink());
}

?>
