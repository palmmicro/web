<?php
require_once('_entertainment.php');
require_once('/php/class/multi_currency.php');

function EchoChineseHoldResult($strOldSZ162411, $strOldXOP, $strSZ162411, $strXOP, $strUSCNY)
{
    $strQuantitySZ162411 = '960000';
    $strQuantityXOP = '1600';
    
    $multi = new MultiCurrency();
    $multi->fCNY = (floatval($strSZ162411) - floatval($strOldSZ162411)) * intval($strQuantitySZ162411);
    $multi->fUSD = (floatval($strXOP) - floatval($strOldXOP)) * intval($strQuantityXOP);
    $multi->Convert(floatval($strUSCNY));
    
    $strRMB = strval_round($multi->fCNY);
    $strUSD = strval_round($multi->fUSD);
    $strConvertRMB = strval_round($multi->fConvertCNY);
    $strConvertUSD = strval_round($multi->fConvertUSD);
    
    echo <<<END
    <ol>
        <li>{$strQuantitySZ162411}股华宝油气获利($strSZ162411 - $strOldSZ162411) * $strQuantitySZ162411 = $strRMB 人民币.</li>
        <li>{$strQuantityXOP}股XOP获利($strXOP - $strOldXOP) * $strQuantityXOP = $strUSD 美元.</li>
        <li>全部换成人民币{$strRMB} + $strUSD * $strUSCNY = $strConvertRMB 人民币.</li>
        <li>全部换成美元{$strRMB} / $strUSCNY + $strUSD = $strConvertUSD 美元.</li>
    </ol>
END;
}


?>
