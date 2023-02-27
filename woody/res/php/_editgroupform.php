<?php
require_once('../../php/ui/stocktable.php');

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
    $strGroupName = '';
    $strStocks = '';
    $strGroupNameDisabled = '0';
    switch ($strSubmit)
    {
    case DISP_EDIT_CN:
        if ($strGroupId = UrlGetQueryValue('edit'))
        {
            $strGroupName = $acct->GetGroupName($strGroupId);
            if (in_arrayAll($strGroupName))		$strGroupNameDisabled = '1';
            $strStocks = _getStocksString($strGroupId);
        }
        break;
    
    case DISP_NEW_CN:
        if ($strSymbol = UrlGetQueryValue('new'))
        {
            $strGroupName = '@'.$strSymbol;
            $strStocks = $strSymbol;
        }
        break;
    }
	
    $col = new TableColumnGroupName();    
    $strStockGroup = $col->GetDisplay();
    
	$strSymbolCol = GetTableColumnSymbol();
    $strPassQuery = UrlPassQuery();
    
	echo <<< END
	<script>
	    function OnLoad()
	    {
	        document.groupForm.groupname.disabled = $strGroupNameDisabled;
	    }
	</script>
	
	<form id="groupForm" name="groupForm" method="post" action="submitgroup.php{$strPassQuery}">
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
