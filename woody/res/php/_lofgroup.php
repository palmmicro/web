<?php
require_once('_fundgroup.php');
require_once('/php/stockhis.php');
require_once('/php/stocktrans.php');
require_once('/php/ui/arbitrageparagraph.php');
require_once('/php/ui/lofsmaparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');

class _LofGroup extends _StockGroup
{
    var $cny_ref;
    var $arLeverage = array();
    var $ar_leverage_ref = array();
    
    function _LofGroup() 
    {
    	foreach ($this->arLeverage as $strSymbol)
    	{
    		$this->ar_leverage_ref[] = new EtfReference($strSymbol);
    	}
        parent::_StockGroup(array_merge(array($this->ref->stock_ref, $this->ref->est_ref), $this->ar_leverage_ref));
    } 
    
    function GetLeverage()
    {
        return $this->arLeverage;
    }

    function GetLeverageRef()
    {
    	return $this->ar_leverage_ref;
    }
    
    function EchoLeverageParagraph($bChinese)
    {
    	if (count($this->ar_leverage_ref) > 0)
    	{
            EchoEtfListParagraph($this->ar_leverage_ref, $bChinese);
//			DebugString('EchoEtfList');
        }
    }

    function GetWebData($strEstSymbol)
    {
        GetChinaMoney();
        YahooUpdateNetValue($strEstSymbol);
        
//        $this->arLeverage = array();
        $sql = new PairStockSql(SqlGetStockId($strEstSymbol), TABLE_ETF_PAIR);
        $ar = $sql->GetAllStockId();
        foreach ($ar as $strStockId)
        {
        	if ($strSymbol = SqlGetStockSymbol($strStockId))
        	{
        		$this->arLeverage[] = $strSymbol;
        		YahooUpdateNetValue($strSymbol);
//        		DebugString($strSymbol);
        	}
        }
    }
    
    function ConvertToEtfTransaction($etf_convert_trans, $lof_trans)
    {
        $fund = $this->ref;
        $etf_convert_trans->AddTransaction($fund->GetEstQuantity($lof_trans->iTotalShares), $lof_trans->fTotalCost / $fund->fCNY);
    }
    
    function ConvertToLofTransaction($lof_convert_trans, $etf_trans)
    {
        $fund = $this->ref;
        $lof_convert_trans->AddTransaction($fund->GetLofQuantity($etf_trans->iTotalShares), $etf_trans->fTotalCost * $fund->fCNY);
    }
    
    function EchoArbitrageParagraph($bChinese)
    {
        $lof_trans = $this->GetStockTransactionCN();
        $etf_trans = $this->GetStockTransactionUS();
        $this->OnArbitrage();
        
        $lof_convert_trans = new MyStockTransaction($this->ref->stock_ref, $this->strGroupId);
        $lof_convert_trans->AddTransaction($lof_trans->iTotalShares, $lof_trans->fTotalCost);
        $this->ConvertToLofTransaction($lof_convert_trans, $etf_trans);
        
        $etf_convert_trans = new MyStockTransaction($this->ref->est_ref, $this->strGroupId);
        $etf_convert_trans->AddTransaction($etf_trans->iTotalShares, $etf_trans->fTotalCost);
        $this->ConvertToEtfTransaction($etf_convert_trans, $lof_trans);
    
        EchoParagraphBegin($bChinese ? '策略分析' : 'Arbitrage analysis');
        EchoArbitrageTableBegin($bChinese);
        $sym = $this->arbi_trans->ref->sym;
        if ($sym->IsSymbolA())
        {
            $arbi_convert_trans = new MyStockTransaction($this->ref->est_ref, $this->strGroupId);
            $this->ConvertToEtfTransaction($arbi_convert_trans, $this->arbi_trans);
            EchoArbitrageTableItem2($this->arbi_trans, $lof_convert_trans); 
            EchoArbitrageTableItem2($arbi_convert_trans, $etf_convert_trans); 
        }
        else
        {
            $arbi_convert_trans = new MyStockTransaction($this->ref->stock_ref, $this->strGroupId);
            $this->ConvertToLofTransaction($arbi_convert_trans, $this->arbi_trans);
            EchoArbitrageTableItem2($arbi_convert_trans, $lof_convert_trans); 
            EchoArbitrageTableItem2($this->arbi_trans, $etf_convert_trans); 
        }
        EchoTableParagraphEnd();
    }

    function _getAdjustString($bChinese)
    {
    	$ref = $this->ref;
        $est_ref = $ref->est_ref;
        $strSymbol = $ref->GetStockSymbol();
        $strDate = $ref->strDate;
        $strCNY = $ref->forex_sql->GetCloseString($strDate);
        
       	$sql = new FundHistorySql($est_ref->GetStockId());
       	$strEst = $sql->GetCloseString($strDate);
       	if ($strEst == false)
       	{
       		$strEst = $sql->stock_sql->GetCloseString($strDate);
       		if ($strEst == false)	$strEst = $est_ref->strPrevPrice;
       	}
       	
        $strQuery = sprintf('%s=%s&%s=%s&CNY=%s', $strSymbol, $ref->strPrice, $est_ref->GetStockSymbol(), $strEst, $strCNY);
        return _GetAdjustLink($strSymbol, $strQuery, $bChinese);
    }

    function EchoAdminTestParagraph($bChinese)
    {
        if (AcctIsAdmin() == false)     return;
        
        $fund = $this->ref;
        $str = $this->_getAdjustString($bChinese);
        if ($fund->est_ref)
        {
            $str .= HTML_NEW_LINE._GetStockConfigDebugString(array($fund->est_ref), $bChinese);
        }
        EchoParagraph($str);
    }
} 

function EchoEstSymbol()
{
    global $group;
    if ($group->ref->est_ref)
    {
        echo $group->ref->est_ref->GetStockSymbol();
    }
}

function EchoMetaDescription($bChinese)
{
    global $group;
    
    $fund = $group->ref;
    $strDescription = _GetStockDisplay($fund->stock_ref);
    $strBase = $group->cny_ref->strDescription;
    if ($fund->est_ref)     $strBase .= '/'.$fund->est_ref->strDescription;
    
    if ($bChinese)  $str = '根据'.$strBase.'等因素计算'.$strDescription.'实时净值的网页工具, 提供不同市场下统一的交易记录和转换持仓盈亏等功能.';
    else              $str = 'Net value of '.$strDescription.' based on '.$strBase.'.';
    EchoMetaDescriptionText($str);
}

?>
