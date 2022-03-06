<?php
require_once('/php/ui/stocktable.php');

define('STOCK_GROUP_NEW', '新建股票分组');
define('STOCK_GROUP_EDIT', '修改股票分组');
define('STOCK_GROUP_ADJUST', '校准');

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

function StockEditGroupForm($acct, $strSubmit)
{
    $strPassQuery = UrlPassQuery();
    $strGroupName = '';
    $strStocks = '';
    $strGroupNameDisabled = '1';
	$strSymbolCol = GetTableColumnSymbol();
    switch ($strSubmit)
    {
    case STOCK_GROUP_EDIT:
        if ($strGroupId = UrlGetQueryValue('edit'))
        {
            $strGroupName = $acct->GetGroupName($strGroupId);
            if (in_arrayAll($strGroupName) == false)     $strGroupNameDisabled = '0';
            $strStocks = _getStocksString($strGroupId);
        }
        break;
    
    case STOCK_GROUP_NEW:
        if ($strSymbol = UrlGetQueryValue('new'))
        {
            $strGroupName = $strSymbol;
            $strGroupNameDisabled = '0';
            $strStocks = $strSymbol;
        }
        break;
    
    case STOCK_GROUP_ADJUST:
        $strStocks = ltrim($strPassQuery, '?adjust=1&');
        $strSymbolCol = '输入美股ETF净值0时会删除当日校准值';
        break;
    }
	
    $col = new TableColumnGroupName();    
    $strStockGroup = $col->GetDisplay();
    
	echo <<< END
	<script>
	    function OnLoad()
	    {
	        document.groupForm.groupname.disabled = $strGroupNameDisabled;
	    }
	</script>
	
	<form id="groupForm" name="groupForm" method="post" action="/woody/res/php/_submitgroup.php$strPassQuery">
        <div>
		<p>$strStockGroup
		<br /><input name="groupname" value="$strGroupName" type="text" size="20" maxlength="32" class="textfield" id="groupname" />
		<br />$strSymbolCol
		<br /><textarea name="symbols" rows="8" cols="75" id="symbols">$strStocks</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
END;
}

?>
