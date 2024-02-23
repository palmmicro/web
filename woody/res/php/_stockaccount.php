<?php

class StockAccount extends TitleAccount
{
    var $strName;

    var $group_sql;
    var $ref = false;		// MysqlReference class
    
    public function __construct($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::__construct($strQueryItem, $arLoginTitle);
        
        $this->strName = StockGetSymbol($this->GetPage());
	    $this->group_sql = new StockGroupSql();
    }

    function GetGroupName($strGroupId)
    {
    	return $this->group_sql->GetString($strGroupId);
    }
    
    function GetGroupLink($strGroupId)
    {
    	if ($strGroupName = $this->GetGroupName($strGroupId))
    	{
    		if ($strLink = GetGroupStockLink($strGroupName))		return $strLink; 
    		return GetMyStockGroupLink('groupid='.$strGroupId, $strGroupName);
    	}
    	return '';
    }

    function GetGroupMemberId($strGroupId)
    {
    	return $this->group_sql->GetKeyId($strGroupId);
    }

    function GetGroupSql()
    {
    	return $this->group_sql;
    }
    
    function GetName()
    {
    	return $this->strName;
    }
    
    function GetRef()
    {
    	return $this->ref;
    }
    
    function SetRef($ref)
    {
    	$this->ref = $ref;
    }
    
    function StockCheckSymbol($str)
    {
    	if (strlen($str) > 11)				return false;		// hf_CHA50CFD is the longest symbol
    	if (strpos($str, "'") !== false)	return false;
    	$str = rtrim($str, '/');
    	return $str;
    }
    
    function _checkPersonalGroupId($strGroupId)
    {	
    	if (method_exists($this, 'GetGroupId') == false)	return true;
    	if ($this->GetGroupId() != $strGroupId)    			return true;
    	return false;
    }

    function _getPersonalGroupLink($strGroupId)
    {
    	$item_sql = new StockGroupItemSql($strGroupId);
    	$arStockId = $item_sql->GetStockIdArray(true);
    	if (count($arStockId) > 0)
    	{
    		if ($strLink = $this->GetGroupLink($strGroupId))	return $strLink.' ';
    	}
    	return '';
    }
    
    function _getPersonalLinks($strLoginId)
    {
    	$str = '';
    	if ($result = $this->group_sql->GetAll($strLoginId)) 
    	{
    		while ($record = mysqli_fetch_assoc($result)) 
    		{
    			$strGroupId = $record['id'];
    			if ($this->_checkPersonalGroupId($strGroupId))		$str .= $this->_getPersonalGroupLink($strGroupId);
    		}
    		mysqli_free_result($result);
    	}
    	if ($str != '')	$str = ' - '.trim($str);
    	return $str;
    }

    function _getStockExchangeLinks($sym)
    {
		if ($sym->IsShenZhenLof())		$str = GetShenZhenLofLink();
		else if ($sym->IsShenZhenEtf())	$str = GetShenZhenEtfListLink();
		else if ($sym->IsShangHaiLof())	$str = GetShangHaiLofShareLink();
		else if ($sym->IsShangHaiEtf())	$str = GetShangHaiEtfShareLink().' '.GetShangHaiEtfListLink();
		else								$str = '';
		
		return $str;
    }
    
    function EchoLinks($strVer = false, $callback = false)
    {
    	$strNewLine = GetBreakElement();
    	$strWeixinPay = GetHtmlElement(GetWeixinPay(($this->GetPage() == 'autotractor') ? 2 : 0));
    	$bAdmin = $this->IsAdmin();
    	
    	$str = GetStockCategoryLinks().$strNewLine.GetAhCompareLink().' '.GetAutoTractorLink().' '.GetAccountToolLink('simpletest').' '.GetDevGuideLink($strVer).$strNewLine;
		if ($strLoginId = $this->GetLoginId())
    	{
    		$str .= GetMyPortfolioLink().$this->_getPersonalLinks($strLoginId);
    		if ($bAdmin)
    		{
    			$strWeixinPay = '';
				$strMemberId = $this->GetMemberId();
    			if (method_exists($this, 'GetGroupId'))
    			{
    				if ($strGroupId = $this->GetGroupId())		$strMemberId = $this->GetGroupMemberId($strGroupId);
    			}
   				if ($strMemberId != $strLoginId)	$str .= $strNewLine.GetMemberLink($strMemberId);
    			$str .= $strNewLine.GetStockPhpLink('debug', STOCK_DISP_DEBUG).' '.GetDebugFileLink().' '.GetFileLink('/php/test.php');
    		}
    		$str .= $strNewLine;
    	}
    	if ($callback)
    	{
    		if ($ref = $this->GetRef())		$str .= $this->_getStockExchangeLinks($ref).' ';
    		$str .= call_user_func($callback, $ref);
    	}
    	else	$str .= GetCategoryLinks(GetStockCategoryArray());
    	
		$strHead = GetHeadElement('相关链接');
		$str = GetHtmlElement($str);
		echo <<<END
			
	$strHead
	$str
	$strWeixinPay
END;
    }
    
    function IsGroupReadOnly($strGroupId)
    {
    	if ($strGroupId)		return ($this->GetGroupMemberId($strGroupId) == $this->GetLoginId()) ? false : true;
    	return false;
    }
    
    function EchoStockTransaction($group)
    {
    	$strGroupId = $group->GetGroupId();
    	if ($this->IsGroupReadOnly($strGroupId) == false)
    	{
    		if ($ref = $this->GetRef())
    		{
    			if ($ref->IsFundA())
    			{
    				SqlCreateFundPurchaseTable();
    				$strStockId = $ref->GetStockId();
    				$strSymbol = $ref->GetSymbol();
    				if (($strAmount = SqlGetFundPurchaseAmount($this->GetLoginId(), $strStockId)) === false)		$strAmount = FUND_PURCHASE_AMOUNT;
    				$strQuery = sprintf('groupid=%s&fundid=%s&amount=%s&netvalue=%.3f', $strGroupId, $strStockId, $strAmount, floatval($ref->GetOfficialNav()));
    				$str = GetOnClickLink(PATH_STOCK.'submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', '申购').$strSymbol.'人民币'.$strAmount.'元';
    				$str .= ' '.GetStockOptionLink(STOCK_OPTION_AMOUNT, $strSymbol);
    				EchoParagraph($str);
    			}
    		}
    		StockEditTransactionForm($this, STOCK_TRANSACTION_NEW, $strGroupId);
    	}
    	
    	if ($group->GetTotalRecords() > 0)
    	{
    		EchoTransactionParagraph($this, $strGroupId, false, false);
    		EchoPortfolioParagraph($group->GetStockTransactionArray());
    		return true;
    	}
    	return false;
    }
    
    function EchoMoneyParagraphs($arGroup, $uscny_ref, $hkcny_ref = false)
    {
    	$strUSDCNY = $uscny_ref ? $uscny_ref->GetPrice() : false;
    	$strHKDCNY = $hkcny_ref ? $hkcny_ref->GetPrice() : false;
	
    	_EchoMoneyParagraphBegin($arGroup);
    	foreach ($arGroup as $group)	_EchoMoneyGroupData($this, $group, $strUSDCNY, $strHKDCNY);
    	EchoTableParagraphEnd();
    }

    function EchoMoneyParagraph($group, $uscny_ref, $hkcny_ref = false)
    {
    	$this->EchoMoneyParagraphs(array($group), $uscny_ref, $hkcny_ref);
    }
}    

?>
