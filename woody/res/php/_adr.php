<?php
require_once('_stock.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/stocksmaparagraph.php');
require_once('/php/ui/tradingparagraph.php');

class _AdrGroup extends _MyStockGroup 
{
    var $cn_ref;
    var $us_ref;
    var $hk_ref;
    
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
        StockPrefetchData(array($strSymbolAdr));
//        PrefetchEastMoneyData(array('USCNY', 'HKCNY'));
        GetChinaMoney();
        
        $this->uscny_ref = new CnyReference('USCNY');
        $this->hkcny_ref = new CnyReference('HKCNY');
        
    	$strSymbolH = SqlGetAdrhPair($strSymbolAdr);
        $strSymbolA = SqlGetHaPair($strSymbolH);
        $this->cn_ref = new MyStockReference($strSymbolA);
        $this->us_ref = new MyStockReference($strSymbolAdr);
        $this->hk_ref = new HAdrReference($strSymbolH, $this->cn_ref, $this->us_ref);

        $this->fUSDCNY = $this->uscny_ref->fPrice;
        $this->fHKDCNY = $this->hkcny_ref->fPrice;
        $this->fUSDHKD = $this->fUSDCNY / $this->fHKDCNY;

        $this->arStockRef = array($this->us_ref, $this->hk_ref, $this->cn_ref);
        $this->arDisplayRef = array_merge($this->arStockRef, array($this->uscny_ref, $this->hkcny_ref));
        
        $this->fRatioAdrH = $this->hk_ref->fAdrRatio;
        $this->fRatioAH = $this->hk_ref->fRatio;

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

function _adrStockRefCallbackData($ref, $bChinese)
{
    global $group;
    $cn_ref = $group->cn_ref;
    $hk_ref = $group->hk_ref;
    $us_ref = $group->us_ref;
    
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $fPrice = $ref->fPrice;
    $sym = $ref->sym;
	$ar = array();
    if ($sym->IsSymbolA())
    {
        $ar[] = $strPriceDisplay;
        $ar[] = $hk_ref->GetPriceDisplay($hk_ref->EstFromCny($fPrice));
        $ar[] = $us_ref->GetPriceDisplay($hk_ref->FromCnyToUsd($fPrice));
    }
    else if ($sym->IsSymbolH())
    {
        $ar[] = $cn_ref->GetPriceDisplay($hk_ref->EstToCny($fPrice));
        $ar[] = $strPriceDisplay;
        $ar[] = $us_ref->GetPriceDisplay($hk_ref->EstToUsd($fPrice));
    }
    else
    {
        $ar[] = $cn_ref->GetPriceDisplay($hk_ref->FromUsdToCny($fPrice));
        $ar[] = $hk_ref->GetPriceDisplay($hk_ref->EstFromUsd($fPrice));
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

function _echoArbitrageParagraph($group, $bChinese)
{
    EchoParagraphBegin($bChinese ? '策略分析' : 'Arbitrage analysis');
    _EchoArbitrageTableBegin($bChinese);

    $cn_trans = $group->GetStockTransactionCN();
    $hk_trans = $group->GetStockTransactionHK();
    $us_trans = $group->GetStockTransactionUS();
    $group->OnConvert($cn_trans, $hk_trans, $us_trans);
    
    $hk_ref = $group->hk_ref;
	$sym = $group->arbi_trans->ref->sym;
    if ($sym->IsSymbolA())
    {
        $cn_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem2($cn_arbi, $group->cn_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH), StockGetPriceDisplay($hk_ref->EstFromCny($cn_arbi->GetAvgCost()), $group->hk_ref->fPrice), $group->hk_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH / $group->fRatioAdrH), StockGetPriceDisplay($hk_ref->FromCnyToUsd($cn_arbi->GetAvgCost()), $group->us_ref->fPrice), $group->us_convert); 
    }
    else if ($sym->IsSymbolH())
    {
        $hk_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAH), StockGetPriceDisplay($hk_ref->EstToCny($hk_arbi->GetAvgCost()), $group->cn_ref->fPrice), $group->cn_convert); 
        _EchoArbitrageTableItem2($hk_arbi, $group->hk_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAdrH), StockGetPriceDisplay($hk_ref->EstToUsd($hk_arbi->GetAvgCost()), $group->us_ref->fPrice), $group->us_convert); 
    }
    else
    {
        $us_arbi = $group->arbi_trans;
        _EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH / $group->fRatioAH), StockGetPriceDisplay($hk_ref->FromUsdToCny($us_arbi->GetAvgCost()), $group->cn_ref->fPrice), $group->cn_convert); 
        _EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH), StockGetPriceDisplay($hk_ref->EstFromUsd($us_arbi->GetAvgCost()), $group->hk_ref->fPrice), $group->hk_convert); 
        _EchoArbitrageTableItem2($us_arbi, $group->us_convert); 
    }
    
    EchoTableEnd();
    EchoParagraphEnd();
}

function _echoAdminTestParagraph($group, $bChinese)
{
    $str = $group->GetDebugString($bChinese);
    $str .= HTML_NEW_LINE._GetStockConfigDebugString(array($group->hk_ref, $group->cn_ref, $group->us_ref), $bChinese);
    EchoParagraph($str);
}

function AdrEchoAll($bChinese)
{
    global $group;
    
    _echoRefParagraph($group, $bChinese);
	EchoAhTradingParagraph($group->hk_ref, $group->hk_ref, $bChinese);
    EchoStockSmaParagraph($group->cn_ref, $group->hk_ref, $group->hk_ref, $bChinese);
    EchoStockSmaParagraph($group->hk_ref, $group->hk_ref, $group->hk_ref, $bChinese);
    EchoStockSmaParagraph($group->us_ref, $group->hk_ref, $group->hk_ref, $bChinese);

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
