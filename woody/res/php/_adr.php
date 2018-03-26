<?php
require_once('_stock.php');
require_once('/php/ui/smaparagraph.php');
require_once('/php/ui/fundtradingparagraph.php');

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
        $this->hk_ref = $this->cn_ref->h_ref;
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
        $this->fRatioAH = AhGetRatio($strSymbolA);

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

function ConvertH2USD($fPriceH, $us_ref)
{
    global $group;
    return _convertH2USD($fPriceH, $group);
}

function ConvertA2USD($fPriceA, $us_ref)
{
    global $group;
    return _convertA2USD($fPriceA, $group);
}


// ****************************** Reference table *******************************************************

function _echoRefTableData($ref, $group)
{
    $sym = $ref->sym;
    $strPriceDisplay = $ref->GetCurrentPriceDisplay();
    $strPercentageDisplay = $ref->GetCurrentPercentageDisplay();
    
    if ($sym->IsSymbolA())
    {
        $strCNY = $strPriceDisplay;
        $strHKD = $group->hk_ref->GetPriceDisplay(_convertA2HKD($ref->fPrice, $group));
        $strUSD = $group->us_ref->GetPriceDisplay(_convertA2USD($ref->fPrice, $group));
    }
    else if ($sym->IsSymbolH())
    {
        $strCNY = $group->cn_ref->GetPriceDisplay(_convertH2CNY($ref->fPrice, $group));
        $strHKD = $strPriceDisplay;
        $strUSD = $group->us_ref->GetPriceDisplay(_convertH2USD($ref->fPrice, $group));
    }
    else
    {
        $strCNY = $group->cn_ref->GetPriceDisplay(_convertAdr2CNY($ref->fPrice, $group));
        $strHKD = $group->hk_ref->GetPriceDisplay(_convertAdr2HKD($ref->fPrice, $group));
        $strUSD = $strPriceDisplay;
    }

    echo <<<END
    <tr>
        <td class=c1>{$ref->strExternalLink}</td>
        <td class=c1>$strPriceDisplay</td>
        <td class=c1>$strPercentageDisplay</td>
        <td class=c1>{$ref->strDate}</td>
        <td class=c1>{$ref->strTimeHM}</td>
        <td class=c1>$strCNY</td>
        <td class=c1>$strHKD</td>
        <td class=c1>$strUSD</td>
    </tr>
END;
}

function _EchoRefTable($group, $bChinese)
{
    if ($bChinese)     
    {
        $arColumn = array('代码', PRICE_DISPLAY_CN, '涨跌', '日期', '时间', '人民币￥', '港币$', '美元$');
    }
    else
    {                                                                                
        $arColumn = array('Symbol', PRICE_DISPLAY_US, 'Change', 'Date', 'Time', 'RMB￥', 'HK$', 'US$');
    }
    
    echo <<<END
        <TABLE borderColor=#cccccc cellSpacing=0 width=590 border=1 class="text" id="reference">
        <tr>
            <td class=c1 width=80 align=center>{$arColumn[0]}</td>
            <td class=c1 width=70 align=center>{$arColumn[1]}</td>
            <td class=c1 width=80 align=center>{$arColumn[2]}</td>
            <td class=c1 width=100 align=center>{$arColumn[3]}</td>
            <td class=c1 width=50 align=center>{$arColumn[4]}</td>
            <td class=c1 width=70 align=center>{$arColumn[5]}</td>
            <td class=c1 width=70 align=center>{$arColumn[6]}</td>
            <td class=c1 width=70 align=center>{$arColumn[7]}</td>
        </tr>
END;

    foreach ($group->arStockRef as $ref)
    {
        _echoRefTableData($ref, $group);
    }
   
    EchoTableEnd();
}

function _echoRefParagraph($group, $bChinese)
{
    EchoParagraphBegin($bChinese ? '价格数据' : 'Price data');
    _EchoRefTable($group, $bChinese);
    EchoParagraphEnd();
}

function _echoTradingParagraph($group, $bChinese)
{
    $strSymbol = $group->cn_ref->GetStockSymbol(); 
    $strSymbolH = $group->hk_ref->GetStockSymbol(); 
    if ($bChinese)     
    {
        $arColumn = array('交易', PRICE_DISPLAY_CN.'(人民币￥)', '数量(手)', PREMIUM_DISPLAY_CN, '', '', '');
        $str = "{$strSymbol}当前5档交易{$arColumn[1]}相对于{$strSymbolH}交易价格<b>{$group->hk_ref->strPrice}</b>港币的{$arColumn[3]}";
    }
    else
    {
        $arColumn = array('Trading', PRICE_DISPLAY_US.'(RMB￥)', 'Num(100)', PREMIUM_DISPLAY_US, '', '', '');
        $str = "The {$arColumn[3]} of $strSymbol Ask/Bid {$arColumn[1]} comparing with $strSymbolH trading price <b>{$group->hk_ref->strPrice}</b>HKD";
    }
    EchoParagraphBegin($str);
    EchoTradingTable($arColumn, $group->cn_ref, _convertH2CNY($group->hk_ref->fPrice, $group), false, false, false, $bChinese); 
    EchoParagraphEnd();
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
