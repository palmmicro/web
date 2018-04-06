<?php

// ****************************** ForexReference Class *******************************************************

function _getForexDescription($strSymbol)
{
    if (UrlIsChinese())
    {
        $ar = array('USDCNY' => '美元人民币汇率',
                      'USCNY' => '美元人民币中间价',
                      'HKCNY' => '港币人民币中间价',
                      'USDHKD' => '美元港币汇率',
                      'DINIW' => '美元指数',
                     );
    }
    else
    {
        $ar = array('USDCNY' => 'USD/CNY Exchange Rate',
                      'USCNY' => 'USD/CNY Reference Rate',
                      'HKCNY' => 'HKD/CNY Reference Rate',
                      'USDHKD' => 'USD/HKD Exchange Rate',
                      'DINIW' => 'USD Index',
                     );
    }
    return $ar[$strSymbol];
}

class ForexReference extends StockReference
{
    public static $iDataSource = STOCK_DATA_SINA;
//    public static $iDataSource = STOCK_DATA_EASTMONEY;

    function _onSinaData($strSymbol)
    {
        $this->strFileName = DebugGetSinaFileName($strSymbol);
        $ar = _GetForexAndFutureArray($strSymbol, $this->strFileName, ForexAndFutureGetTimezone(), GetSinaQuotes);
        if (count($ar) < 10)
        {
            $this->bHasData = false;
            return;
        }
        
        $this->strTime = $ar[0];
        $this->strPrevPrice = $ar[3];
        $this->strPrice = $ar[8];
        $this->strDate = $ar[10];
        
        $this->strExternalLink = GetSinaForexLink($strSymbol);
    }       

    function _onEastMoneyData($strSymbol)
    {
        $this->strFileName = DebugGetEastMoneyFileName($strSymbol);
        $ar = _GetForexAndFutureArray(ForexGetEastMoneySymbol($strSymbol), $this->strFileName, ForexAndFutureGetTimezone(), GetEastMoneyQuotes);
        if (count($ar) < 27)
        {
            $this->bHasData = false;
            return;
        }
        $this->_getEastMoneyForexData($ar);

        $this->strExternalLink = GetEastMoneyForexLink($strSymbol);
    }       

    // constructor 
    function ForexReference($strSymbol)
    {
        if (self::$iDataSource == STOCK_DATA_SINA)
        {
            $this->_onSinaData($strSymbol);
        }
        else
        {
            $this->_onEastMoneyData($strSymbol);
        }
        parent::StockReference($strSymbol);
        $this->strDescription = _getForexDescription($strSymbol);
    }       
}

// Only East Money has USCNY/HKCNY reference rate 
class CnyReference extends StockReference
{
    // constructor 
    function CnyReference($strSymbol)
    {
        $this->_newStockSymbol($strSymbol);
        $this->strFileName = DebugGetEastMoneyFileName($strSymbol);
        if (($str = IsNewDailyQuotes($this->sym, $this->strFileName, true, _GetEastMoneyQuotesYMD)) === false)
        {
            $str = GetEastMoneyQuotes(ForexGetEastMoneySymbol($strSymbol));
            if ($str)   file_put_contents($this->strFileName, $str);
            else         $str = file_get_contents($this->strFileName);
        }
        
        $this->_getEastMoneyForexData(explodeQuote($str));
//        if (floatval($this->strOpen) > MIN_FLOAT_VAL)   $this->strPrice = $this->strOpen;
//        else                                               $this->strPrice = $this->strPrevPrice;
        $this->strPrice = $this->strOpen;
        
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
        
        parent::StockReference($strSymbol);
        $this->strDescription = _getForexDescription($strSymbol);
    }       
}

?>
