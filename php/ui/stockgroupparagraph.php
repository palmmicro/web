<?php

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

function StockGroupGetStockLinks($strGroupId, $bChinese)
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

function _echoStockGroupTableItem($strGroupId, $bReadOnly, $bChinese)
{
    if ($bReadOnly)
    {
        $strDelete = '';
        $strEdit = '';
    }
    else
    {
        $strDelete = UrlGetDeleteLink(STOCK_PHP_PATH.'_submitgroup.php?delete='.$strGroupId, '股票分组和相关交易记录', 'stock group and related stock transactions', $bChinese);
        $strEdit = StockGetEditGroupLink($strGroupId, $bChinese);
    }
    
    $strLink = SelectGroupInternalLink($strGroupId, $bChinese);
    $strStocks = StockGroupGetStockLinks($strGroupId, $bChinese);

    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strEdit $strDelete</td>
    </tr>
END;
}

function _echoStockGroupTableData($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$strStockId = SqlGetStockId($strSymbol);
    }
    
    $strMemberId = AcctGetMemberId();
    $bReadOnly = AcctIsReadOnly($strMemberId);
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
			$strGroupId = $stockgroup['id'];
			if (($strSymbol == false) || StockGroupHasSymbol($strGroupId, $strStockId))
			{
				_echoStockGroupTableItem($strGroupId, $bReadOnly, $bChinese);
			}
		}
		@mysql_free_result($result);
	}
}

function EchoStockGroupParagraph($bChinese)
{
    $arColumn = GetStockGroupTableColumn($bChinese);
    
    EchoParagraphBegin('');
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="stockgroup">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=440 align=center>{$arColumn[1]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
    </tr>
END;

    _echoStockGroupTableData($bChinese);
    EchoTableEnd();
    EchoParagraphEnd();
}

?>
