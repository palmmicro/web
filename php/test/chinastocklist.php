<?php

function StockBuildChineseFundSymbol($strDigit)
{
    if (IsChineseStockDigit($strDigit))
    {
        $iDigit = intval($strDigit);
        if (_isShanghaiFundDigit($iDigit))
        {
            return SHANGHAI_PREFIX.$strDigit;
        }
        else if (_isShenzhenFundDigit($iDigit))
        {
            return SHENZHEN_PREFIX.$strDigit;
        }
    }
    return false;
}            

function TestChinaFundList()
{
    $file = fopen('/debug/chinafundlist.txt', 'r');
//    $strLine = fgets($file);   // bypass first line
    while (!feof($file))
    {
        $strLine = fgets($file);
        if ($strLeft = strstr($strLine, '<span>', true))
        {
            $strName = FromGB2312ToUTF8(substr($strLeft, 6));
            $strNumber = substr($strLeft, 0, 6);
            if (($strSymbol = StockBuildChineseFundSymbol($strNumber)) == false)
            {
                $strSymbol = 'f_'.$strNumber;
            }
//            DebugString($strSymbol.' '.$strName);
            if (SqlGetStock($strSymbol) == false)
            {
                SqlInsertStock($strSymbol, $strName, $strName);
            }
        }
    }
    fclose($file);
}

function TestChinaStockList()
{
    $file = fopen('/debug/chinastocklist.txt', 'r');
    $strLine = fgets($file);   // bypass first line
    while (!feof($file))
    {
        $strLine = fgets($file);
        $arWord = explode("\t", $strLine);
        $str = $arWord[0];
        
        if (IsChineseStockDigit($str))
        {
            $strSymbol = StockBuildChineseSymbol($str);
            $strName = FromGB2312ToUTF8($arWord[1]);
            DebugString($strSymbol.' '.$strName);
            if (SqlGetStock($strSymbol) == false)
            {
                SqlInsertStock($strSymbol, $strName, $strName);
            }
        }
    }
    fclose($file);
}

define('US_STOCK_SEPARATER', ',');
function TestUsStockList()
{
    $file = fopen('/debug/usstocklist.txt', 'r');
    while (!feof($file))
    {
        $strLine = fgets($file);
        if ($str = strstr($strLine, 'title='))
        {
            $str = RemoveDoubleQuotationMarks($str);
            $arWord = explode(US_STOCK_SEPARATER, $str);
            $strSymbol = $arWord[0];
//            $strEnglish = str_replace("'", "''", $arWord[1]);   // mysql use 2 continues single quotes for 1
            $strEnglish = $arWord[1];
            for ($i = 2; $i < count($arWord) - 1; $i ++)
            {   // English name might have explode separater ','
                $strEnglish .= US_STOCK_SEPARATER.$arWord[$i];
            }
            $strChinese = FromGB2312ToUTF8($arWord[$i]);
            DebugString($strSymbol.' '.$strEnglish.' '.$strChinese);
            
            if ($stock = SqlGetStock($strSymbol))
            {
                SqlUpdateStock($stock['id'], $strSymbol, $strEnglish, $strChinese);
            }
            else
            {
                SqlInsertStock($strSymbol, $strEnglish, $strChinese);
            }
        }
    }
    fclose($file);
}

?>
