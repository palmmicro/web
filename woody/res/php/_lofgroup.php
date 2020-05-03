<?php
require_once('_stockgroup.php');
require_once('_fundgroup.php');
require_once('/php/ui/arbitrageparagraph.php');
require_once('/php/ui/lofsmaparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');

class LofGroupAccount extends FundGroupAccount 
{
    var $cny_ref;
    var $arLeverage = array();
    var $ar_leverage_ref = array();
    
    function LofGroupAccount() 
    {
        parent::FundGroupAccount();
    }
    
    function LofCreateGroup()
    {
    	foreach ($this->arLeverage as $strSymbol)
    	{
    		$this->ar_leverage_ref[] = new EtfReference($strSymbol);
    	}
        $this->CreateGroup(array_merge(array($this->ref->stock_ref, $this->ref->GetEstRef()), $this->ar_leverage_ref));
    } 
    
    function GetLeverage()
    {
        return $this->arLeverage;
    }

    function GetLeverageRef()
    {
    	return $this->ar_leverage_ref;
    }
    
    function EchoLeverageParagraph()
    {
    	if (count($this->ar_leverage_ref) > 0)
    	{
            EchoEtfListParagraph($this->ar_leverage_ref);
//			DebugString('EchoEtfList');
        }
    }

    function GetWebData($strEstSymbol)
    {
        GetChinaMoney();
        YahooUpdateNetValue($strEstSymbol);

        $sql = new EtfPairSql(SqlGetStockId($strEstSymbol));
        if ($strPairId = $sql->GetPairId())
        {
        	if ($strSymbol = SqlGetStockSymbol($strPairId))
        	{
        		// DebugString($strSymbol.'=>'.$strEstSymbol);
        		YahooUpdateNetValue($strSymbol);
        	}
        }
        
        $ar = $sql->GetAllStockId();
        foreach ($ar as $strStockId)
        {
        	if ($strSymbol = SqlGetStockSymbol($strStockId))
        	{
        		// DebugString($strEstSymbol.'=>'.$strSymbol);
        		$this->arLeverage[] = $strSymbol;
        		YahooUpdateNetValue($strSymbol);
        	}
        }
    }
    
    function ConvertToEtfTransaction($etf_convert_trans, $lof_trans)
    {
        $fund = $this->ref;
        $etf_convert_trans->AddTransaction($fund->GetEstQuantity($lof_trans->iTotalShares), $lof_trans->fTotalCost / floatval($fund->strCNY));
    }
    
    function ConvertToLofTransaction($lof_convert_trans, $etf_trans)
    {
        $fund = $this->ref;
        $lof_convert_trans->AddTransaction($fund->GetLofQuantity($etf_trans->iTotalShares), $etf_trans->fTotalCost * floatval($fund->strCNY));
    }
    
//    function EchoArbitrageParagraph()
    function EchoArbitrageParagraph($group)
    {
/*        $lof_trans = $this->GetStockTransactionCN();
        $etf_trans = $this->GetStockTransactionNoneCN();
        $this->OnArbitrage();*/
        
        $lof_trans = $group->GetStockTransactionCN();
        $etf_trans = $group->GetStockTransactionNoneCN();
        $group->OnArbitrage();
        
        $strGroupId = $group->GetGroupId();
        
//        $lof_convert_trans = new MyStockTransaction($this->ref->stock_ref, $this->strGroupId);
        $lof_convert_trans = new MyStockTransaction($this->ref->stock_ref, $strGroupId);
        $lof_convert_trans->AddTransaction($lof_trans->iTotalShares, $lof_trans->fTotalCost);
        $this->ConvertToLofTransaction($lof_convert_trans, $etf_trans);
        
//        $etf_convert_trans = new MyStockTransaction($this->ref->GetEstRef(), $this->strGroupId);
        $etf_convert_trans = new MyStockTransaction($this->ref->GetEstRef(), $strGroupId);
        $etf_convert_trans->AddTransaction($etf_trans->iTotalShares, $etf_trans->fTotalCost);
        $this->ConvertToEtfTransaction($etf_convert_trans, $lof_trans);
    
        EchoArbitrageTableBegin();
//        $sym = $this->arbi_trans->ref;
		$arbi_trans = $group->arbi_trans;
        $sym = $arbi_trans->ref;
        if ($sym->IsSymbolA())
        {
//            $arbi_convert_trans = new MyStockTransaction($this->ref->GetEstRef(), $this->strGroupId);
            $arbi_convert_trans = new MyStockTransaction($this->ref->GetEstRef(), $strGroupId);
//            $this->ConvertToEtfTransaction($arbi_convert_trans, $this->arbi_trans);
//            EchoArbitrageTableItem2($this->arbi_trans, $lof_convert_trans); 
            $this->ConvertToEtfTransaction($arbi_convert_trans, $arbi_trans);
            EchoArbitrageTableItem2($arbi_trans, $lof_convert_trans); 
            EchoArbitrageTableItem2($arbi_convert_trans, $etf_convert_trans); 
        }
        else
        {
//            $arbi_convert_trans = new MyStockTransaction($this->ref->stock_ref, $this->strGroupId);
//            $this->ConvertToLofTransaction($arbi_convert_trans, $this->arbi_trans);
            $arbi_convert_trans = new MyStockTransaction($this->ref->stock_ref, $strGroupId);
            $this->ConvertToLofTransaction($arbi_convert_trans, $arbi_trans);
            EchoArbitrageTableItem2($arbi_convert_trans, $lof_convert_trans); 
//            EchoArbitrageTableItem2($this->arbi_trans, $etf_convert_trans); 
            EchoArbitrageTableItem2($arbi_trans, $etf_convert_trans); 
        }
        EchoTableParagraphEnd();
    }

    function _getAdjustString()
    {
    	$ref = $this->ref;
        $est_ref = $ref->GetEstRef();
        $strSymbol = $ref->GetSymbol();
        $strDate = $ref->GetDate();
        $strCNY = $ref->forex_sql->GetClose($strDate);
        
       	$sql = new NetValueHistorySql($est_ref->GetStockId());
       	$strEst = $sql->GetClose($strDate);
       	if ($strEst == false)
       	{
       		$strEst = $est_ref->his_sql->GetClose($strDate);
       		if ($strEst == false)	$strEst = $est_ref->GetPrevPrice();
       	}
       	
        $strQuery = sprintf('%s=%s&%s=%s&CNY=%s', $strSymbol, $ref->GetPrice(), $est_ref->GetSymbol(), $strEst, $strCNY);
        return _GetAdjustLink($strSymbol, $strQuery);
    }

    function EchoTestParagraph()
    {
       	if (RefHasData($this->ref->GetEstRef()))
       	{
       		$str = $this->_getAdjustString();
       		EchoParagraph($str);
	    }
    }
} 

function EchoMetaDescription()
{
//    global $group;
    global $acct;
    
//    $fund = $group->ref;
    $fund = $acct->GetRef();
    $strDescription = RefGetStockDisplay($fund->stock_ref);
//    $strBase = RefGetDescription($group->cny_ref);
    $strBase = RefGetDescription($acct->cny_ref);
    $est_ref = $fund->GetEstRef();
    if ($est_ref)     $strBase .= '/'.RefGetDescription($est_ref);
    
    $str = '根据'.$strBase.'等因素计算'.$strDescription.'实时净值的网页工具, 提供不同市场下统一的交易记录和转换持仓盈亏等功能.';
    EchoMetaDescriptionText($str);
}

?>
