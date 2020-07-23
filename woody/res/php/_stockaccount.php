<?php

class StockAccount extends TitleAccount
{
    var $strName;

    var $ref = false;		// MysqlReference class
	
    function StockAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::TitleAccount($strQueryItem, $arLoginTitle);
        
        $this->strName = StockGetSymbol($this->GetTitle());
    }

    function GetName()
    {
    	return $this->strName;
    }
    
    function GetRef()
    {
    	return $this->ref;
    }
    
    function _checkPersonalGroupId($strGroupId)
    {	
    	if (method_exists($this, 'GetGroupId') == false)	return true;
    	if ($this->GetGroupId() != $strGroupId)    			return true;
    	return false;
    }

    function _getPersonalGroupLink($strGroupId)
    {
    	$sql = new StockGroupItemSql($strGroupId);
    	$arStockId = $sql->GetStockIdArray(true);
    	if (count($arStockId) > 0)
    	{
    		return GetStockGroupLink($strGroupId);
    	}
    	return '';
    }
    
    function _getPersonalLinks($strMemberId)
    {
    	$str = ' - ';
    	$sql = new StockGroupSql($strMemberId);
    	if ($result = $sql->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strGroupId = $record['id'];
    			if ($this->_checkPersonalGroupId($strGroupId))
    			{
    				$str .= $this->_getPersonalGroupLink($strGroupId).' ';
    			}
    		}
    		@mysql_free_result($result);
    	}
    	return $str;
    }

    function EchoLinks($strVer = false, $callback = false)
    {
    	$strLoginId = $this->GetLoginId();
    	EchoPromotionHead($strVer, $strLoginId);

    	if ($callback)
    	{
    		$str = call_user_func($callback, $this->GetRef());
    	}
    	else
    	{
    		$str = GetCategoryLinks(GetStockCategoryArray());
    	}
    	$str .= '<br />'.GetCategoryLinks(GetStockMenuArray());
    	$str .= '<br />'.GetMyStockGroupLink();	// .' '.GetAhCompareLink().' '.GetAdrhCompareLink();
    	$str .= '<br />'.GetMyPortfolioLink();
    	if ($strLoginId)
    	{
    		$str .= $this->_getPersonalLinks($strLoginId);
       		$str .= '<br />'.GetVisitorLink();
    	}
    	EchoParagraph($str);
    }
    
    function IsGroupReadOnly($strGroupId)
    {
    	if ($strGroupId == false)	return true;
    	
    	return (SqlGetStockGroupMemberId($strGroupId) == $this->GetLoginId()) ? false : true;
    }
    
    function EchoStockTransaction($group)
    {
    	$strGroupId = $group->GetGroupId();
    
    	if ($this->IsGroupReadOnly($strGroupId) == false)
    	{
    		StockEditTransactionForm(STOCK_TRANSACTION_NEW, $strGroupId);
    	}
    	
    	if ($group->GetTotalRecords() > 0)
    	{
    		EchoTransactionParagraph($this, $strGroupId, false, false);
    		EchoPortfolioParagraph(GetMyPortfolioLink(), $group->GetStockTransactionArray());
    		return true;
    	}
    	return false;
    }
}    

?>
