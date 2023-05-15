<?php

class StockAccount extends TitleAccount
{
    var $strName;

    var $group_sql;
    var $ref = false;		// MysqlReference class
    
    function StockAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::TitleAccount($strQueryItem, $arLoginTitle);
        
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
    		if ($strLink = GetStockLink($strGroupName))		return $strLink; 
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
    	if (in_array($str, GetOldSymbolArray()))
   		{
   			if (!$this->IsAdmin())
   			{
   				if ($this->SetCrawler(UrlGetIp()))	DebugString('标注查退市股的爬虫');
   			}
   		}
   		
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
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strGroupId = $record['id'];
    			if ($this->_checkPersonalGroupId($strGroupId))		$str .= $this->_getPersonalGroupLink($strGroupId);
    		}
    		@mysql_free_result($result);
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
    	
    	EchoHeadLine('相关链接');
    	$str = GetStockCategoryLinks().' '.GetAutoTractorLink().' '.GetSimpleTestLink().' '.GetDevGuideLink($strVer).$strNewLine;
		if ($strLoginId = $this->GetLoginId())
    	{
    		$str .= GetMyPortfolioLink().$this->_getPersonalLinks($strLoginId);
    		if ($this->IsAdmin())
    		{
				$strMemberId = $this->GetMemberId();
    			if (method_exists($this, 'GetGroupId'))
    			{
    				if ($strGroupId = $this->GetGroupId())		$strMemberId = $this->GetGroupMemberId($strGroupId);
    			}
   				if ($strMemberId != $strLoginId)	$str .= $strNewLine.GetMemberLink($strMemberId);
    			$str .= $strNewLine.GetStockPhpLink('debug', STOCK_DISP_DEBUG).' '.GetDebugFileLink().' '.GetWebFileLink('php/test.php');
    		}
    		$str .= $strNewLine;
    	}
    	if ($callback)
    	{
    		if ($ref = $this->GetRef())		$str .= $this->_getStockExchangeLinks($ref).' ';
    		$str .= call_user_func($callback, $ref);
    	}
    	else	$str .= GetCategoryLinks(GetStockCategoryArray());
    	EchoParagraph($str);
//    	_echoRandomPromotion();
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
    				$str = GetOnClickLink(STOCK_PATH.'submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', '申购').$strSymbol.'人民币'.$strAmount.'元';
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
