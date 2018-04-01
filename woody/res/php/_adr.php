<?php
require_once('_stock.php');
require_once('/php/ui/smaparagraph.php');
require_once('/php/ui/tradingparagraph.php');

function _getRatioAdrH($strSymbolAdr)
{
    if ($strSymbolAdr == 'ACH')         return 25.0;
    else if ($strSymbolAdr == 'CEA')   return 50.0;
    else if ($strSymbolAdr == 'CHU')   return 10.0;
    else if ($strSymbolAdr == 'GSH')   return 50.0;
    else if ($strSymbolAdr == 'LFC')   return 5.0;
    else if ($strSymbolAdr == 'ZNH')   return 50.0;
    else 
        return 100.0;
}

function _getAdrSymbolA($strSymbolAdr)
{
    if ($strSymbolAdr == 'ACH')         return 'SH601600';
    else if ($strSymbolAdr == 'CEA')   return 'SH600115';
    else if ($strSymbolAdr == 'CHU')   return 'SH600050';
    else if ($strSymbolAdr == 'GSH')   return 'SH601333';
    else if ($strSymbolAdr == 'LFC')   return 'SH601628';
    else if ($strSymbolAdr == 'PTR')   return 'SH601857';
    else if ($strSymbolAdr == 'SHI')   return 'SH600688';
    else if ($strSymbolAdr == 'SNP')   return 'SH600028';
    else if ($strSymbolAdr == 'ZNH')   return 'SH600029';
    else 
        return false;
}

class _AdrGroup extends _MyStockGroup 
{
    var $cn_ref;
    var $us_ref;
    var $hk_ref;
    
    var $cn_his;
    var $hk_his;

    var $uscny_ref;
    var $hkcny_ref;
    
    var $fUSDCNY;
    var $fHKDCNY;
    var $fUSDHKD;
    
    var $arStockRef;
    
    var $fRatioAdrH;
    var $fRatioAH;

    var $cn_convert;
    var $us_convert;
    var $hk_convert;
    
    // constructor
    function _AdrGroup($strSymbolAdr) 
    {
        $strSymbolA = _getAdrSymbolA($strSymbolAdr);
        PrefetchForexAndStockData(array($strSymbolAdr, $strSymbolA));
        
        $this->cn_ref = new MyStockReference($strSymbolA);
        $this->hk_ref = new MyStockReference(SqlGetAhPair($strSymbolA));
        $this->us_ref = new MyStockReference($strSymbolAdr);

        $this->hk_his = new StockHistory($this->hk_ref);
        $this->cn_his = new StockHistory($this->cn_ref);
        
        $this->uscny_ref = new CNYReference('USCNY');
        $this->hkcny_ref = new CNYReference('HKCNY');
        
        $this->fUSDCNY = $this->uscny_ref->fPrice;
        $this->fHKDCNY = $this->hkcny_ref->fPrice;
        $this->fUSDHKD = $this->fUSDCNY / $this->fHKDCNY;

        $this->arStockRef = array($this->us_ref, $this->hk_ref, $this->cn_ref);
        $this->arDisplayRef = array_merge($this->arStockRef, array($this->uscny_ref, $this->hkcny_ref));
        
        $this->fRatioAdrH = _getRatioAdrH($strSymbolAdr);
        $this->fRatioAH = SqlGetAhPairRatio($this->cn_ref);

        parent::_MyStockGroup($this->arStockRef);
    }
    
    function OnConvert($cn_trans, $hk_trans, $us_trans)
    {
        $this->OnArbitrage();

        $this->cn_convert = new MyStockTransaction($this->cn_ref, $this->strGroupId);
        $this->cn_convert->AddTransaction($cn_trans->iTotalShares, $cn_trans->fTotalCost);
        $this->cn_convert->AddTransaction(intval($hk_trans->iTotalShares / $this->fRatioAH), $hk_trans->fTotalCost * $this->fHKDCNY);
        $this->cn_convert->AddTransaction(intval($us_trans->iTotalShares * $this->fRatioAdrH / $this->fRatioAH), $us_trans->fTotalCost * $this->fUSDCNY);
        
        $this->hk_convert = new MyStockTransaction($this->hk_ref, $this->strGroupId);
        $this->hk_convert->AddTransaction($hk_trans->iTotalShares, $hk_trans->fTotalCost);
        $this->hk_convert->AddTransaction(intval($cn_trans->iTotalShares * $this->fRatioAH), $cn_trans->fTotalCost / $this->fHKDCNY);
        $this->hk_convert->AddTransaction(intval($us_trans->iTotalShares * $this->fRatioAdrH), $us_trans->fTotalCost * $this->fUSDHKD);
        
        $this->us_convert = new MyStockTransaction($this->us_ref, $this->strGroupId);
        $this->us_convert->AddTransaction($us_trans->iTotalShares, $us_trans->fTotalCost);
        $this->us_convert->AddTransaction(intval($cn_trans->iTotalShares * $this->fRatioAH / $this->fRatioAdrH), $cn_trans->fTotalCost / $this->fUSDCNY);
        $this->us_convert->AddTransaction(intval($hk_trans->iTotalShares / $this->fRatioAdrH), $hk_trans->fTotalCost / $this->fUSDHKD);
    }
} 

function _convertH2CNY($fPriceH, $group)
{
    return ($fPriceH * $group->fRatioAH) * $group->fHKDCNY;
}

function _convertA2HKD($fPrice, $group)
{
    return ($fPrice / $group->fRatioAH) / $group->fHKDCNY;
}

function _convertH2USD($fPriceH, $group)
{
    return ($fPriceH * $group->fRatioAdrH) / $group->fUSDHKD;
}

function _convertAdr2HKD($fPriceAdr, $group)
{
    return ($fPriceAdr / $group->fRatioAdrH) * $group->fUSDHKD;
}

function _convertA2USD($fPrice, $group)
{
    return ($fPrice * $group->fRatioAdrH / $group->fRatioAH) / $group->fUSDCNY;
}

function _convertAdr2CNY($fPriceAdr, $group)
{
    return ($fPriceAdr / $group->fRatioAdrH * $group->fRatioAH) * $group->fUSDCNY;
}

function _adrStockRefCallbackData($ref, $bChinese)
{
    global $group;
    
    $sym = $ref->sym;
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $fPrice = $ref->fPrice;
	$ar = array();
    if ($sym->IsSymbolA())
    {
        $ar[] = $strPriceDisplay;
        $ar[] = $group->hk_ref->GetPriceDisplay(_convertA2HKD($fPrice, $group));
        $ar[] = $group->us_ref->GetPriceDisplay(_convertA2USD($fPrice, $group));
    }
    else if ($sym->IsSymbolH())
    {
        $ar[] = $group->cn_ref->GetPriceDisplay(_convertH2CNY($fPrice, $group));
        $ar[] = $strPriceDisplay;
        $ar[] = $group->us_ref->GetPriceDisplay(_convertH2USD($fPrice, $group));
    }
    else
    {
        $ar[] = $group->cn_ref->GetPriceDisplay(_convertAdr2CNY($fPrice, $group));
        $ar[] = $group->hk_ref->GetPriceDisplay(_convertAdr2HKD($fPrice, $group));
        $ar[] = $strPriceDisplay;
    }
	return $ar;
}

function _adrStockRefCallback($ref, $bChinese)
{
    if ($ref)
    {
        return _adrStockRefCallbackData($ref, $bChinese);
    }
    
    if ($bChinese)  $arColumn = array('人民币￥', '港币$', '美元$');
    else              $arColumn = array('RMB￥', 'HK$', 'US$');
    return $arColumn;
}

function _echoRefParagraph($group, $bChinese)
{
    EchoParagraphBegin($bChinese ? '价格数据' : 'Price data');
    EchoStockRefTable($group->arStockRef, _adrStockRefCallback, $bChinese);
    EchoParagraphEnd();
}

function _echoTradingParagraph($group, $bChinese)
{
	EchoAhTradingParagraph($group->cn_ref, $group->hk_ref->GetStockSymbol(), $group->hk_ref->strPrice, _convertH2CNY($group->hk_ref->fPrice, $group), $bChinese);
}

function ConvertH2USD($fPriceH, $us_ref)
{
    global $group;
    if ($fPriceH)		return _convertH2USD($fPriceH, $group);
    return $us_ref->GetStockSymbol();
}

function ConvertA2USD($fPriceA, $us_ref)
{
    global $group;
    if ($fPriceA)		return _convertA2USD($fPriceA, $group);
    return $us_ref->GetStockSymbol();
}

function _echoAvgParagraph($group, $bChinese)
{
    EchoSmaParagraph($group->hk_his, $group->us_ref, ConvertH2USD, false, $bChinese);
    EchoSmaParagraph($group->cn_his, $group->us_ref, ConvertA2USD, false, $bChinese);
}

function _echoArbitrageParagraph($group, $bChinese)
{
    EchoParagraphBegin($bChinese ? '策略分析' : 'Arbitrage analysis');
    _EchoArbitrageTableBegin($bChinese);

    $cn_trans = $group->GetStockTransactionCN();
    $hk_trans = $group->GetStockTransactionHK();
    $us_trans = $group->GetStockTransactionUS();
    $group->OnConvert($cn_trans, $hk_trans, $us_trans);
    
    $sym = $group->arbi_trans->ref->sym;
    if ($sym->IsSymbolA())
    {
        $cn_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem2($cn_arbi, $group->cn_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH), StockGetPriceDisplay(_convertA2HKD($cn_arbi->GetAvgCost(), $group), $group->hk_ref->fPrice), $group->hk_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH / $group->fRatioAdrH), StockGetPriceDisplay(_convertA2USD($cn_arbi->GetAvgCost(), $group), $group->us_ref->fPrice), $group->us_convert); 
    }
    else if ($sym->IsSymbolH())
    {
        $hk_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAH), StockGetPriceDisplay(_convertH2CNY($hk_arbi->GetAvgCost(), $group), $group->cn_ref->fPrice), $group->cn_convert); 
        _EchoArbitrageTableItem2($hk_arbi, $group->hk_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAdrH), StockGetPriceDisplay(_convertH2USD($hk_arbi->GetAvgCost(), $group), $group->us_ref->fPrice), $group->us_convert); 
    }
    else
    {
        $us_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH / $group->fRatioAH), StockGetPriceDisplay(_convertAdr2CNY($us_arbi->GetAvgCost(), $group), $group->cn_ref->fPrice), $group->cn_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH), StockGetPriceDisplay(_convertAdr2HKD($us_arbi->GetAvgCost(), $group), $group->hk_ref->fPrice), $group->hk_convert); 
        _EchoArbitrageTableItem2($us_arbi, $group->us_convert); 
    }
    
    EchoTableEnd();
    EchoParagraphEnd();
}

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = $group->GetDebugString($bChinese);
    $str .= HTML_NEW_LINE._GetStockHistoryDebugString(array($group->hk_his, $group->cn_his), $bChinese);
    EchoParagraph($str);
}

function AdrEchoAll($bChinese)
{
    global $group;
    
    _echoRefParagraph($group, $bChinese);
    _echoTradingParagraph($group, $bChinese);
    _echoAvgParagraph($group, $bChinese);

    if ($group->strGroupId) 
    {
        _EchoTransactionParagraph($group, $bChinese);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $group->fUSDCNY, $group->fHKDCNY, $bChinese);
            _echoArbitrageParagraph($group, $bChinese);
        }
	}
    
    EchoPromotionHead('adr', $bChinese);
    if (AcctIsAdmin())
    {
        _echoAdminTestParagraph($group, $bChinese);
    }
}

function AdrEchoTitle($bChinese)
{
    global $group;
    
    $strDescription = _GetStockDisplay($group->us_ref);
    if ($bChinese)
    {
        $str = '比较'.$strDescription.'美股, 港股和A股的价格';
    }
    else
    {
        $str = 'Comparing the Price of '.$strDescription;
    }
    echo $str;
}

function AdrEchoMetaDescription($bChinese)
{
    global $group;
    
    $strAdr = _GetStockDisplay($group->us_ref);
    $strA = _GetStockDisplay($group->cn_ref);
    $strH = _GetStockDisplay($group->hk_ref);
    if ($bChinese)
    {
        $str = '根据'.$group->uscny_ref->strDescription.'和'.$group->hkcny_ref->strDescription.'计算比较美股'.$strAdr.', A股'.$strA.'和港股'.$strH.'价格的网页工具, 提供不同市场下统一的交易记录和转换持仓盈亏等功能.';
    }
    else
    {
        $str = 'To compare the price of '.$strAdr.', '.$strA.' and '.$strH.' in US, China and Hongkong market.';
    }
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _AdrGroup(StockGetSymbolByUrl());
?>
