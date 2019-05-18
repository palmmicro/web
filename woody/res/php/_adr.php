<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
require_once('/php/stocktrans.php');
require_once('/php/ui/arbitrageparagraph.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/hsharesmaparagraph.php');
require_once('/php/ui/tradingparagraph.php');

class _AdrGroup extends _StockGroup 
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
    
    function _AdrGroup($strSymbolAdr)
    {
        StockPrefetchData($strSymbolAdr);
        GetChinaMoney();
        
        $this->uscny_ref = new CnyReference('USCNY');
        $this->hkcny_ref = new CnyReference('HKCNY');
        
        $this->hk_ref = new HShareReference(SqlGetAdrhPair($strSymbolAdr));
        $this->cn_ref = $this->hk_ref->a_ref;
        $this->us_ref = $this->hk_ref->adr_ref;

        $this->fUSDCNY = floatval($this->uscny_ref->GetCurrentPrice());
        $this->fHKDCNY = floatval($this->hkcny_ref->GetCurrentPrice());
        $this->fUSDHKD = $this->fUSDCNY / $this->fHKDCNY;

        $this->arStockRef = array($this->us_ref, $this->hk_ref, $this->cn_ref);
       
        $this->fRatioAdrH = $this->hk_ref->GetAdrRatio();
        $this->fRatioAH = $this->hk_ref->GetRatio();

        parent::_StockGroup($this->arStockRef);
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

function _echoArbitrageParagraph($group)
{
    $cn_trans = $group->GetStockTransactionCN();
    $hk_trans = $group->GetStockTransactionHK();
    $us_trans = $group->GetStockTransactionUS();
    $group->OnConvert($cn_trans, $hk_trans, $us_trans);
    
    $cn_ref = $group->cn_ref;
    $hk_ref = $group->hk_ref;
    $us_ref = $group->us_ref;
    if ($group->arbi_trans == false)		return;
    
    EchoParagraphBegin('策略分析');
    EchoArbitrageTableBegin();
	$sym = $group->arbi_trans->ref->sym;
    if ($sym->IsSymbolA())
    {
        $cn_arbi = $group->arbi_trans;
        EchoArbitrageTableItem2($cn_arbi, $group->cn_convert); 
        EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH), $hk_ref->GetPriceDisplay($hk_ref->EstFromCny($cn_arbi->GetAvgCost()), false), $group->hk_convert); 
        EchoArbitrageTableItem(intval(-1.0 * $cn_arbi->iTotalShares * $group->fRatioAH / $group->fRatioAdrH), $us_ref->GetPriceDisplay($hk_ref->FromCnyToUsd($cn_arbi->GetAvgCost()), false), $group->us_convert); 
    }
    else if ($sym->IsSymbolH())
    {
        $hk_arbi = $group->arbi_trans;
        EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAH), $cn_ref->GetPriceDisplay($hk_ref->EstToCny($hk_arbi->GetAvgCost()), false), $group->cn_convert); 
        EchoArbitrageTableItem2($hk_arbi, $group->hk_convert); 
        EchoArbitrageTableItem(intval(-1.0 * $hk_arbi->iTotalShares / $group->fRatioAdrH), $us_ref->GetPriceDisplay($hk_ref->EstToUsd($hk_arbi->GetAvgCost()), false), $group->us_convert); 
    }
    else
    {
        $us_arbi = $group->arbi_trans;
        EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH / $group->fRatioAH), $cn_ref->GetPriceDisplay($hk_ref->FromUsdToCny($us_arbi->GetAvgCost()), false), $group->cn_convert); 
        EchoArbitrageTableItem(intval(-1.0 * $us_arbi->iTotalShares * $group->fRatioAdrH), $hk_ref->GetPriceDisplay($hk_ref->EstFromUsd($us_arbi->GetAvgCost()), false), $group->hk_convert); 
        EchoArbitrageTableItem2($us_arbi, $group->us_convert); 
    }
    
    EchoTableParagraphEnd();
}

function _adrStockRefCallbackData($ref)
{
    global $group;
    $cn_ref = $group->cn_ref;
    $hk_ref = $group->hk_ref;
    $us_ref = $group->us_ref;
    
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPrice = $ref->GetCurrentPrice();
	$ar = array();
    $sym = $ref->GetSym();
    if ($sym->IsSymbolA())
    {
        $ar[] = $strPriceDisplay;
        $ar[] = $hk_ref->GetPriceDisplay($hk_ref->EstFromCny($strPrice));
        $ar[] = $us_ref->GetPriceDisplay($hk_ref->FromCnyToUsd($strPrice));
    }
    else if ($sym->IsSymbolH())
    {
        $ar[] = $cn_ref->GetPriceDisplay($hk_ref->EstToCny($strPrice));
        $ar[] = $strPriceDisplay;
        $ar[] = $us_ref->GetPriceDisplay($hk_ref->EstToUsd($strPrice));
    }
    else
    {
        $ar[] = $cn_ref->GetPriceDisplay($hk_ref->FromUsdToCny($strPrice));
        $ar[] = $hk_ref->GetPriceDisplay($hk_ref->EstFromUsd($strPrice));
        $ar[] = $strPriceDisplay;
    }
	return $ar;
}

function _adrStockRefCallback($ref = false)
{
    if ($ref)
    {
        return _adrStockRefCallbackData($ref);
    }
    
    return array('人民币￥', '港币$', '美元$');
}

function AdrEchoAll()
{
    global $group;
    
    EchoReferenceParagraph($group->arStockRef, '_adrStockRefCallback');
	EchoAhTradingParagraph($group->hk_ref);
    EchoHShareSmaParagraph($group->cn_ref, $group->hk_ref);
    EchoHShareSmaParagraph($group->hk_ref, $group->hk_ref);
//    EchoHShareSmaParagraph($group->us_ref, $group->hk_ref);

    if ($group->GetGroupId()) 
    {
        _EchoTransactionParagraph($group);
        if ($group->GetTotalRecords() > 0)
        {
            EchoMoneyParagraph($group, $group->uscny_ref->GetCurrentPrice(), $group->hkcny_ref->GetCurrentPrice());
            _echoArbitrageParagraph($group);
        }
	}
    
    EchoPromotionHead('adr');
}

function AdrEchoTitle()
{
    global $group;
    
    $strDescription = RefGetStockDisplay($group->us_ref);
    $str = '比较'.$strDescription.'对应港股和A股的价格';
    echo $str;
}

function AdrEchoMetaDescription()
{
    global $group;
    
    $strAdr = RefGetStockDisplay($group->us_ref);
    $strA = RefGetStockDisplay($group->cn_ref);
    $strH = RefGetStockDisplay($group->hk_ref);
    $str = '根据'.RefGetDescription($group->uscny_ref).'和'.RefGetDescription($group->hkcny_ref).'计算比较美股'.$strAdr.', A股'.$strA.'和港股'.$strH.'价格的网页工具, 提供不同市场下统一的交易记录和转换持仓盈亏等功能.';
    EchoMetaDescriptionText($str);
}

    AcctNoAuth();
    $group = new _AdrGroup(StockGetSymbolByUrl());
?>
