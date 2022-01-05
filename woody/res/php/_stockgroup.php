<?php
require_once('/php/stockgroup.php');
require_once('/php/stockhis.php');

class GroupAccount extends StockAccount
{
    var $group = false;	//  MyStockGroup
	
    function GetGroup()
    {
    	return $this->group;
    }
    
    function GetGroupId()
    {
    	if ($group = $this->GetGroup())
    	{
    		return $group->GetGroupId();
    	}
    	return false;
    }
    
    function CreateGroup($arRef)
    {
    	if (($strLoginId = $this->GetLoginId()) == false)		return;
    	
        $sql = $this->GetGroupSql();
        $strGroupName = $this->GetName();
        if ($strGroupId = $sql->GetRecordId($strLoginId, $strGroupName))
        {
        	$arNew = array();
            foreach ($arRef as $ref)
            {
               	$arNew[] = $ref->GetStockId();
            }      
            SqlUpdateStockGroup($strGroupId, $arNew);
        }
        else
        {
			$sql->InsertString($strLoginId, $strGroupName);
            if ($strGroupId = $sql->GetRecordId($strLoginId, $strGroupName))
            {
            	$item_sql = new StockGroupItemSql($strGroupId);
                foreach ($arRef as $ref)
                {
                   	$item_sql->Insert($ref->GetStockId());
                }      
            }
        }
        
        if ($strGroupId)		$this->group = new MyStockGroup($strGroupId, $arRef);
    }
    
    function EchoTransaction()
    {
    	if ($group = $this->GetGroup()) 
    	{
    		if ($this->EchoStockTransaction($group))
    		{
    			return $group;
    		}
        }
        return false;
	}
	
    function GetFundPurchaseAmount()
    {
    	$strAmount = FUND_PURCHASE_AMOUNT;
    	if ($group = $this->GetGroup()) 
    	{
    		SqlCreateFundPurchaseTable();
    		$ref = $this->GetRef();
    		if ($str = SqlGetFundPurchaseAmount($this->GetLoginId(), $ref->GetStockId()))
    		{
    			$strAmount = $str;
    		}
    	}
    	return $strAmount;
    }

    function GetFundPurchaseLink($strAmount, $fQuantity)
    {
    	$strQuantity = strval(intval($fQuantity));
    	if ($group = $this->GetGroup()) 
    	{
    		$ref = $this->GetRef();
    		$strQuery = sprintf('groupid=%s&fundid=%s&amount=%s&netvalue=%s', $group->GetGroupId(), $ref->GetStockId(), $strAmount, $ref->GetOfficialNav());
    		return GetOnClickLink(STOCK_PHP_PATH.'_submittransaction.php?'.$strQuery, '确认添加对冲申购记录?', $strQuantity);
    	}
    	return $strQuantity;
    }
}

function GetArbitrageQuantityName($bEditLink = false)
{
    global $acct;
    
    $ref = $acct->GetRef();
    if ($acct->GetGroup() && $bEditLink) 
    {
    	return GetStockOptionLink(STOCK_OPTION_AMOUNT, $ref->GetSymbol());
    }
    return STOCK_OPTION_AMOUNT;
}

function FundTradingUserDefined($strVal = false)
{
    if ($strVal)
    {
    	if ($strVal == '0')	return '';
    	else					return _onTradingUserDefined($strVal);				
    }
   	return GetArbitrageQuantityName(true);
}


?>
