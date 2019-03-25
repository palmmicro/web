<?php
require_once('stocktable.php');

function StockGroupIsReadOnly($strGroupId)
{
    $strMemberId = SqlGetStockGroupMemberId($strGroupId);
    return AcctIsReadOnly($strMemberId);
}

function _stockGroupGetStockLinks($strGroupId, $bChinese)
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

function _echoStockGroupTableItem($strGroupId, $bChinese)
{
    if (StockGroupIsReadOnly($strGroupId))
    {
        $strEdit = '';
        $strDelete = '';
    }
    else
    {	// editstockgroupcn.php?edit=24
    	$strEdit = GetEditLink(STOCK_PATH.'editstockgroup', $strGroupId, $bChinese);
        $strDelete = GetDeleteLink(STOCK_PHP_PATH.'_submitgroup.php?delete='.$strGroupId, '股票分组和相关交易记录', 'stock group and related stock transactions', $bChinese);
    }
    
    $strLink = GetStockGroupLink($strGroupId);
    $strStocks = _stockGroupGetStockLinks($strGroupId, $bChinese);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strEdit $strDelete</td>
    </tr>
END;
}

function _echoNewStockGroupTableItem($strSymbol, $bChinese)
{
   	$strStocks = GetMyStockLink($strSymbol);
   	$strNew = GetNewLink(STOCK_PATH.'editstockgroup', $strSymbol, $bChinese);
    echo <<<END
    <tr>
        <td class=c1></td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strNew</td>
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
    {	// in pages like mystock
    	$strStockId = SqlGetStockId($strSymbol);
    }
    
    $iTotal = 0;
	$sql = new StockGroupSql(AcctGetMemberId());
	if ($result = $sql->GetAll()) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
			$strGroupId = $stockgroup['id'];
			if (($strSymbol == false) || SqlGroupHasStock($strGroupId, $strStockId))
			{
				_echoStockGroupTableItem($strGroupId, $bChinese);
				$iTotal ++;
			}
		}
		@mysql_free_result($result);
	}
	
	if ($strSymbol && $iTotal == 0)
	{
		_echoNewStockGroupTableItem($strSymbol, $bChinese);
	}
}

function EchoStockGroupParagraph($bChinese = true)
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

    _echoStockGroupTableData($bChinese);
    EchoTableParagraphEnd();
}

?>
