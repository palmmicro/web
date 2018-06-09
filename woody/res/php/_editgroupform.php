<?php
require_once('/php/ui/stocktable.php');

define ('STOCK_GROUP_NEW', 'New Group');
define ('STOCK_GROUP_NEW_CN', '新建分组');

define ('STOCK_GROUP_EDIT', 'Edit Group');
define ('STOCK_GROUP_EDIT_CN', '修改分组');

define ('STOCK_GROUP_ADJUST', 'Adjust');
define ('STOCK_GROUP_ADJUST_CN', '校准');

function IsGroupNameReadOnly($strGroupName)
{
    if (in_arrayLof($strGroupName))               return true;
    if (in_arrayLofHk($strGroupName))             return true;
    if (in_arrayGoldEtf($strGroupName))           return true;
    if (in_arrayPairTrading($strGroupName))       return true;
    if (in_arrayGradedFund($strGroupName))        return true;
    if (in_arrayAdr($strGroupName))               return true;
    return false;
}

function _getStocksString($strGroupId)
{
    if ($arSymbol = SqlGetStocksArray($strGroupId))
    {
    	$strStocks = '';
    	foreach ($arSymbol as $strSymbol)
    	{
    		$strStocks .= $strSymbol.', ';
    	}
    	return rtrim($strStocks, ', ');
    }
    return '';
}

function StockEditGroupForm($str, $bChinese)
{
    $arColumn = GetStockGroupTableColumn($bChinese);
    $strPassQuery = UrlPassQuery();
	$strSubmit = $str;
    $strGroupName = '';
    $strStocks = '';
    $strGroupNameDisabled = '1';
    if ($strSubmit == STOCK_GROUP_EDIT_CN || $strSubmit == STOCK_GROUP_EDIT)
    {
        if ($strGroupId = UrlGetQueryValue('edit'))
        {
            $strGroupName = SqlGetStockGroupName($strGroupId);
            if (IsGroupNameReadOnly($strGroupName) == false)     $strGroupNameDisabled = '0';
            $strStocks = _getStocksString($strGroupId);
        }
        else
        {
            $strSubmit = ($strSubmit == STOCK_GROUP_EDIT_CN) ? STOCK_GROUP_ADJUST_CN : STOCK_GROUP_ADJUST;
            $strStocks = ltrim($strPassQuery, '?');
        }
    }
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	        document.groupForm.groupname.disabled = $strGroupNameDisabled;
	    }
	</script>
	
	<form id="groupForm" name="groupForm" method="post" action="/woody/res/php/_submitgroup.php$strPassQuery">
        <div>
		<p>{$arColumn[0]}
		<br /><input name="groupname" value="$strGroupName" type="text" size="20" maxlength="32" class="textfield" id="groupname" />
		<br />{$arColumn[1]}
		<br /><textarea name="symbols" rows="8" cols="75" id="symbols">$strStocks</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
END;
}

?>
