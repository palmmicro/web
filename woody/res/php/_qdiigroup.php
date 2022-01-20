<?php
require_once('_stockgroup.php');
require_once('_fundgroup.php');
require_once('/php/ui/arbitrageparagraph.php');
require_once('/php/ui/qdiismaparagraph.php');
require_once('/php/ui/etfsmaparagraph.php');
require_once('/php/ui/etfparagraph.php');

class QdiiGroupAccount extends FundGroupAccount 
{
    var $arLeverage = array();
    var $ar_leverage_ref = array();
    
    function QdiiCreateGroup()
    {
    	$ref = $this->GetRef();
    	$stock_ref = $ref->GetStockRef();
       	$est_ref = $ref->GetEstRef();
    	
        YahooUpdateNetValue($est_ref);
        GetChinaMoney($stock_ref);
        SzseGetLofShares($stock_ref);
        
    	foreach ($this->arLeverage as $strSymbol)
    	{
    		$leverage_ref = new EtfReference($strSymbol);
    		$this->ar_leverage_ref[] = $leverage_ref;
    		YahooUpdateNetValue($leverage_ref);
    	}
        $this->CreateGroup(array_merge(array($stock_ref, $est_ref), $this->ar_leverage_ref));
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

    function GetLeverageSymbols($strEstSymbol)
    {
        $sql = new EtfPairSql(SqlGetStockId($strEstSymbol));
        $ar = $sql->GetAllStockId();
        foreach ($ar as $strStockId)
        {
        	if ($strSymbol = SqlGetStockSymbol($strStockId))
        	{
        		$this->arLeverage[] = $strSymbol;
        	}
        }
    }
    
    function ConvertToEtfTransaction($fund, $fCNY, $etf_convert_trans, $qdii_trans)
    {
        $etf_convert_trans->AddTransaction($fund->GetEstQuantity($qdii_trans->iTotalShares), $qdii_trans->fTotalCost / $fCNY);
    }
    
    function ConvertToQdiiTransaction($fund, $fCNY, $qdii_convert_trans, $etf_trans)
    {
        $qdii_convert_trans->AddTransaction($fund->GetQdiiQuantity($etf_trans->iTotalShares), $etf_trans->fTotalCost * $fCNY);
    }
    
    function EchoArbitrageParagraph($group)
    {
    	$fund = $this->GetRef();
    	$stock_ref = $fund->GetStockRef();
    	$est_ref = $fund->GetEstRef();
    	$cny_ref = $fund->GetCnyRef();
    	$fCNY = floatval($cny_ref->GetPrice());
	
        $qdii_trans = $group->GetStockTransactionCN();
        $etf_trans = $group->GetStockTransactionNoneCN();
        $group->OnArbitrage();
        
        $strGroupId = $group->GetGroupId();
        
        $qdii_convert_trans = new MyStockTransaction($stock_ref, $strGroupId);
        $qdii_convert_trans->Add($qdii_trans);
        $this->ConvertToQdiiTransaction($fund, $fCNY, $qdii_convert_trans, $etf_trans);
        
        $etf_convert_trans = new MyStockTransaction($est_ref, $strGroupId);
        $etf_convert_trans->Add($etf_trans);
        $this->ConvertToEtfTransaction($fund, $fCNY, $etf_convert_trans, $qdii_trans);
    
        EchoArbitrageTableBegin();
		$arbi_trans = $group->arbi_trans;
        $sym = $arbi_trans->ref;
        if ($sym->IsSymbolA())
        {
            $arbi_convert_trans = new MyStockTransaction($est_ref, $strGroupId);
            $this->ConvertToEtfTransaction($fund, $fCNY, $arbi_convert_trans, $arbi_trans);
            EchoArbitrageTableItem2($arbi_trans, $qdii_convert_trans); 
            EchoArbitrageTableItem2($arbi_convert_trans, $etf_convert_trans); 
        }
        else
        {
            $arbi_convert_trans = new MyStockTransaction($stock_ref, $strGroupId);
            $this->ConvertToQdiiTransaction($fund, $fCNY, $arbi_convert_trans, $arbi_trans);
            EchoArbitrageTableItem2($arbi_convert_trans, $qdii_convert_trans); 
            EchoArbitrageTableItem2($arbi_trans, $etf_convert_trans); 
        }
        EchoTableParagraphEnd();
    }

    function _getAdjustString()
    {
    	$ref = $this->ref;
        $strSymbol = $ref->GetSymbol();
        $strDate = $ref->GetDate();
        $est_ref = $ref->GetEstRef();
        $cny_ref = $ref->GetCnyRef();
        $strCNY = $cny_ref->GetClose($strDate);
        
        $strEstStockId = $est_ref->GetStockId();
       	$strEst = SqlGetNavByDate($strEstStockId, $strDate);
       	if ($strEst == false)
       	{
       		$strEst = SqlGetHisByDate($strEstStockId, $strDate);
       		if ($strEst == false)	$strEst = $est_ref->GetPrevPrice();
       	}
       	
        $strQuery = sprintf('Date=%s&%s=%s&%s=%s&CNY=%s', $strDate, $strSymbol, $ref->GetPrice(), $est_ref->GetSymbol(), $strEst, $strCNY);
        return _GetAdjustLink($strSymbol, $strQuery);
    }

    function EchoTestParagraph()
    {
    	if ($this->IsAdmin() == false)	return;
    	
       	if (RefHasData($this->ref->GetEstRef()))
       	{
       		$str = $this->_getAdjustString();
       		EchoParagraph($str);
	    }
    }
} 

function TradingUserDefined($strVal = false)
{
	global $acct;
    
	$fund = $acct->GetRef();
	$est_ref = $fund->GetEstRef();

    if ($strVal)
    {
    	if ($strVal == '0')	return '';
    	else
    	{
    		$strEst = $fund->GetEstValue($strVal);
    		return $est_ref->GetPriceDisplay($strEst);
    	}
    }
    
   	return GetStockChartsLink($est_ref->GetSymbol()).GetTableColumnPrice();
}

function EchoMetaDescription()
{
    global $acct;
    
    $strDescription = $acct->GetStockDisplay();

    $fund = $acct->GetRef();
    $strBase = RefGetDescription($fund->GetCnyRef());
    $est_ref = $fund->GetEstRef();
    if ($est_ref)     $strBase .= '/'.RefGetDescription($est_ref);
    
    $str = '根据'.$strBase.'等其它网站数据估算'.$strDescription.'净值的网页工具.';
    EchoMetaDescriptionText($str);
}

?>
