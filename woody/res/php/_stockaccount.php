<?php

class StockAccount extends TitleAccount
{
    var $strName;

    var $ref = false;		// MysqlReference class
	
    var $group_sql;
    
    function StockAccount($strQueryItem = false, $arLoginTitle = false) 
    {
        parent::TitleAccount($strQueryItem, $arLoginTitle);
        
        $this->strName = StockGetSymbol($this->GetTitle());
	    $this->group_sql = new StockGroupSql($this->GetLoginId());
    }

    function GetGroupName($strGroupId)
    {
//    	DebugString('Trace GetGroupName');
    	return $this->group_sql->GetVal($strGroupId);
    }

    function GetGroupMemberId($strGroupId)
    {
    	return $this->group_sql->GetKeyId($strGroupId);
    }

    function GetGroupSql()
    {
//    	DebugString('Trace GetGroupSql');
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
    
    function _getPersonalLinks()
    {
    	$str = ' - ';
//    	$sql = new StockGroupSql($strMemberId);
    	if ($result = $this->group_sql->GetAll()) 
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
    		$str .= $this->_getPersonalLinks();
    		if ($this->IsAdmin())
    		{
    			$str .= '<br />'.GetPhpLink(STOCK_PATH.'admintest', false, '超级功能测试');
    			$str .= ' '.GetPhpLink(STOCK_PATH.'admindebug', false, '超级调试信息');
    			$str .= ' '.GetFileLink(DebugGetFile());
    			$str .= ' '.GetFileLink('/php/test.php');
    		}
    	}
    	EchoParagraph($str);
    }
    
    function IsGroupReadOnly($strGroupId)
    {
    	if ($strGroupId == false)	return true;
    	
    	return ($this->GetGroupMemberId($strGroupId) == $this->GetLoginId()) ? false : true;
    }
    
    function EchoStockTransaction($group)
    {
    	$strGroupId = $group->GetGroupId();
    
    	if ($this->IsGroupReadOnly($strGroupId) == false)
    	{
    		StockEditTransactionForm($this, STOCK_TRANSACTION_NEW, $strGroupId);
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
