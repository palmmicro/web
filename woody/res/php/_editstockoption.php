<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

function _getOperationStr($bChinese)
{
    if (UrlGetQueryValue('edit'))
    {
    	$str = $bChinese ? STOCK_OPTION_EDIT_CN : STOCK_OPTION_EDIT;
    }
    else if (UrlGetQueryValue('adr'))
    {
    	$str = $bChinese ? STOCK_OPTION_ADR_CN : STOCK_OPTION_ADR;
    }
    else if (UrlGetQueryValue('ah'))
    {
    	$str = $bChinese ? STOCK_OPTION_AH_CN : STOCK_OPTION_AH;
    }
    else if (UrlGetQueryValue('ema'))
    {
    	$str = $bChinese ? STOCK_OPTION_EMA_CN : STOCK_OPTION_EMA;
    }
    else if (UrlGetQueryValue('etf'))
    {
    	$str = $bChinese ? STOCK_OPTION_ETF_CN : STOCK_OPTION_ETF;
    }
    else if (UrlGetQueryValue('split'))
    {
    	$str = $bChinese ? STOCK_OPTION_SPLIT_CN : STOCK_OPTION_SPLIT;
    }
    else
    {
    	$str = $bChinese ? STOCK_OPTION_AMOUNT_CN : STOCK_OPTION_AMOUNT;
    }
    return $str;
}

function EchoAll($bChinese = true)
{
    StockOptionEditForm(_getOperationStr($bChinese));
}

function EchoMetaDescription($bChinese = true)
{
    if ($bChinese)
    {
        $str = '本中文页面文件跟/woody/res/php/_submitstockoptions.php和/woody/res/php/_editstockoptionform.php一起配合';
    }
    else
    {
        $str = 'This English web page works together with php/_submitstockoptions.php and php/_editstockoptionform.php to ';
    }
    $str .= _getOperationStr($bChinese);
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
    echo _getOperationStr($bChinese);
}

    AcctAuth();
    
?>
