<?php
require_once('stocktable.php');

function StockGroupIsReadOnly($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
    return AcctIsReadOnly($strMemberId);
}

function _stockGroupGetStockLinks($strGroupId)
{
	static $arSymbol = array();
	
    $strStocks = '';
	$arStock = SqlGetStocksArray($strGroupId);
	foreach ($arStock as $strSymbol)
	{
		if (in_array($strSymbol, $arSymbol))
		{
			$strStocks .= $strSymbol;
		}
		else
		{
			$strStocks .= GetMyStockLink($strSymbol);
			$arSymbol[] = $strSymbol;
		}
		$strStocks .= ', ';
	}
	$strStocks = rtrim($strStocks, ', ');
	return $strStocks;
}

function _echoStockGroupTableItem($strGroupId, $strLoginId = false)
{
    $strEdit = '';
    $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submitgroup.php?delete='.$strGroupId, '股票分组和相关交易记录');
    if (SqlGetStockGroupMemberId($strGroupId) == $strLoginId)
    {
    	$strEdit = GetEditLink(STOCK_PATH.'editstockgroup', $strGroupId);
    }
    else if (AcctIsAdmin($strLoginId) == false)
    {
        $strDelete = '';
    }

    $ar = array();
    $ar[] = GetStockGroupLink($strGroupId);
    $ar[] = _stockGroupGetStockLinks($strGroupId);
    $ar[] = $strEdit.' '.$strDelete;
    EchoTableColumn($ar);
}

function _echoNewStockGroupTableItem($strStockId, $strLoginId = false)
{
    $ar = array();
    
	$strSymbol = SqlGetStockSymbol($strStockId);
	$ar[] = ($strLoginId) ? '' : GetStockLink($strSymbol);
   	$ar[] = GetMyStockLink($strSymbol);
   	if ($strLoginId)
   	{
   		$ar[] = GetNewLink(STOCK_PATH.'editstockgroup', $strSymbol);
   	}
    EchoTableColumn($ar);
}

function _echoStockGroupTableData($strStockId, $strMemberId, $strLoginId)
{
    $iTotal = 0;
	$sql = new StockGroupSql($strMemberId);
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			$strGroupId = $record['id'];
			if (($strStockId == false) || SqlGroupHasStock($strGroupId, $strStockId))
			{
				_echoStockGroupTableItem($strGroupId, $strLoginId);
				$iTotal ++;
			}
		}
		@mysql_free_result($result);
	}

	if ($strStockId && $iTotal == 0)
	{
		_echoNewStockGroupTableItem($strStockId, $strLoginId);
	}
}

function EchoAllStockGroupParagraph($strGroupId = false, $strStockId = false, $strMemberId = false, $strLoginId = false)
{
    $strStockGroup = GetMyStockGroupLink();
	$strSymbol = GetTableColumnSymbol();
    
    echo <<<END
    <p>
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stockgroup">
    <tr>
        <td class=c1 width=100 align=center>$strStockGroup</td>
        <td class=c1 width=440 align=center>$strSymbol</td>
        <td class=c1 width=100 align=center></td>
    </tr>
END;

	if ($strGroupId)
	{
		_echoStockGroupTableItem($strGroupId, $strLoginId);
	}
	else
	{
   		if ($strLoginId)
    	{
    		_echoStockGroupTableData($strStockId, $strMemberId, $strLoginId);
    	}
    	else
    	{
    		_echoNewStockGroupTableItem($strStockId);
    	}
	}
    EchoTableParagraphEnd();
}

?>
