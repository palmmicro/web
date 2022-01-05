<?php
require_once('_stock.php');
require_once('_qdiigroup.php');

class _QdiiAccount extends QdiiGroupAccount
{
    var $oil_ref = false;
    var $cnh_ref;

    function Create() 
    {
        $strSymbol = $this->GetName();
        
        $strOil = in_arrayOilQdii($strSymbol) ? 'hf_OIL' : false;
        $strEst = QdiiGetEstSymbol($strSymbol);
        
        $this->GetWebData($strEst);

//        $strUSD = 'DINIW';
        $strCNH = 'fx_susdcnh';
        StockPrefetchArrayExtendedData(array_merge($this->GetLeverage(), array($strSymbol, $strOil, $strCNH)));
        
        $this->ref = new QdiiReference($strSymbol);
        if ($strOil)	$this->oil_ref = new FutureReference($strOil);
        $this->cnh_ref = new ForexReference($strCNH);
        
		$this->QdiiCreateGroup();
    }
} 

function _onSmaUserDefinedVal($strVal)
{
    global $acct;
    
    if (empty($strVal))	return '';
	
    $fund = $acct->GetRef();
    $strAmount = $acct->GetFundPurchaseAmount();
	$fQuantity = $fund->GetFundPosition() * floatval($strAmount) / floatval($fund->strOfficialCNY) / floatval($strVal);
	return $acct->GetFundPurchaseLink($strAmount, $fQuantity);
}

function _onSmaUserDefined($strVal = false, $strNext = false)
{
    if ($strVal === false)
    {
    	return GetArbitrageQuantityName();
    }

    $str = _onSmaUserDefinedVal($strVal);
    if ($strNext)
    {
       	$str .= '/'._onSmaUserDefinedVal($strNext);
    }
    return $str;
}

function _onTradingUserDefined($strVal)
{
	global $acct;
    
	$fund = $acct->GetRef();
	$strEst = $fund->GetEstValue($strVal);
	$est_ref = $fund->GetEstRef();
	return _onSmaUserDefinedVal($strEst).'@'.$est_ref->GetPriceDisplay($strEst);
}

function EchoAll()
{
   	global $acct;
    
   	$fund = $acct->GetRef();
    $stock_ref = $fund->GetStockRef();
	$est_ref = $fund->GetEstRef();
	$cny_ref = $fund->GetCnyRef();
    
    EchoFundEstParagraph($fund);
    EchoReferenceParagraph(array_merge(array($stock_ref, $est_ref, $fund->GetFutureRef(), $acct->oil_ref, $acct->cnh_ref, $cny_ref), $acct->ar_leverage_ref));
    $acct->EchoLeverageParagraph();
    EchoFundTradingParagraph($fund, 'FundTradingUserDefined');    
	EchoQdiiSmaParagraph($fund, '_onSmaUserDefined');
    EchoEtfArraySmaParagraph($est_ref, $acct->GetLeverageRef());
    EchoFundHistoryParagraph($fund);
      
    if ($group = $acct->EchoTransaction()) 
    {
        $acct->EchoMoneyParagraph($group, $cny_ref);
        $acct->EchoArbitrageParagraph($group);
	}
	    
    $acct->EchoTestParagraph();
    $acct->EchoLinks(false, 'GetQdiiRelated');
}

function GetQdiiLinks($sym)
{
	$str = '';
	
	if ($sym->IsShenZhenLof())		$str .= ' '.GetShenZhenLofLink();
	else if ($sym->IsShangHaiLof())	$str .= ' '.GetShangHaiLofShareLink();
	else if ($sym->IsShangHaiEtf())	$str .= ' '.GetShangHaiEtfLinks();
	
	$strSymbol = $sym->GetSymbol();
	if (in_arrayOilQdii($strSymbol))
	{
		$str .= ' '.GetUscfLink();
	}
/*	
	$strFutureSymbol = QdiiGetFutureSymbol($strSymbol);
	if ($strFutureSymbol == 'hf_CL')								
	{
	}
	
	if (in_arraySpyQdii($strSymbol))
	{
	}
*/	
	if (in_arrayQqqQdii($strSymbol))
	{
		$str .= ' '.GetInvescoOfficialLink('QQQ');
	}
	
	$str .= '<br />&nbsp';
	$str .= GetASharesSoftwareLinks();
	$str .= GetChinaInternetSoftwareLinks();
	$str .= GetHSharesSoftwareLinks();
	$str .= GetSpySoftwareLinks();
	return $str;
}

   	$acct = new _QdiiAccount();
   	$acct->Create();
?>
