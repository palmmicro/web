<?php
require_once('stocktable.php');

function StockGroupIsReadOnly($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
    return AcctIsReadOnly($strMemberId);
}

function StockGroupHasSymbol($strGroupId, $strStockId)
{
    if ($result = SqlGetStockGroupItemByGroupId($strGroupId))
	{
        while ($stockgroupitem = mysql_fetch_assoc($result)) 
		{
		    if ($stockgroupitem['stock_id'] == $strStockId)
		    {
		    	return $stockgroupitem;
		    }        
		}
		@mysql_free_result($result);
	}
	return false;
}

function _stockGroupGetStockLinks($strGroupId, $bChinese)
{
    $strStocks = '';
	$arStock = SqlGetStocksArray($strGroupId);
	foreach ($arStock as $strSymbol)
	{
	    $strStocks .= GetMyStockLink($strSymbol, $bChinese).', ';
	}
	$strStocks = rtrim($strStocks, ', ');
	return $strStocks;
}

function _echoStockGroupTableItem($strGroupId, $bChinese)
{
    if (StockGroupIsReadOnly($strGroupId))
    {
        $strEditDelete = '';
    }
    else
    {
        $strEditDelete = GetDeleteLink(STOCK_PHP_PATH.'_submitgroup.php?delete='.$strGroupId, '股票分组和相关交易记录', 'stock group and related stock transactions', $bChinese);
        $strEditDelete .= ' '.StockGetEditGroupLink($strGroupId, $bChinese);
    }
    
    $strLink = SelectGroupInternalLink($strGroupId, $bChinese);
    $strStocks = _stockGroupGetStockLinks($strGroupId, $bChinese);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strEditDelete</td>
    </tr>
END;
}

function _echoStockGroupTableData($bChinese)
{
    if ($strGroupId = UrlGetQueryValue('groupid'))
    {
		_echoStockGroupTableItem($strGroupId, $bChinese);
		return;
    }

    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$strStockId = SqlGetStockId($strSymbol);
    }
    
    $strMemberId = AcctGetMemberId();
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
			$strGroupId = $stockgroup['id'];
			if (($strSymbol == false) || StockGroupHasSymbol($strGroupId, $strStockId))
			{
				_echoStockGroupTableItem($strGroupId, $bChinese);
			}
		}
		@mysql_free_result($result);
	}
}

function EchoStockGroupParagraph($bChinese)
{
    $arColumn = GetStockGroupTableColumn($bChinese);
    $arColumn[0] = GetMyStockGroupLink($bChinese);
    
    EchoParagraphBegin();
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stockgroup">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=440 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
    </tr>
END;

    _echoStockGroupTableData($bChinese);
    EchoTableParagraphEnd();
}

?>
