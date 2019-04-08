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
    
    $strLink = GetStockGroupLink($strGroupId);
    $strStocks = _stockGroupGetStockLinks($strGroupId);
    
    echo <<<END
    <tr>
        <td class=c1>$strLink</td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strEdit $strDelete</td>
    </tr>
END;
}

function _echoNewStockGroupTableItem($strStockId)
{
	$strSymbol = SqlGetStockSymbol($strStockId);
   	$strStocks = GetMyStockLink($strSymbol);
   	$strNew = GetNewLink(STOCK_PATH.'editstockgroup', $strSymbol);
    echo <<<END
    <tr>
        <td class=c1></td>
        <td class=c1>$strStocks</td>
        <td class=c1>$strNew</td>
    </tr>
END;
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
		_echoNewStockGroupTableItem($strStockId);
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
		_echoStockGroupTableData($strStockId, $strMemberId, $strLoginId);
	}
    EchoTableParagraphEnd();
}

function EchoStockGroupParagraph()
{
	$strMemberId = AcctGetMemberId();
	$strLoginId = AcctIsLogin();
	
    if ($strGroupId = UrlGetQueryValue('groupid'))
    {
    	EchoAllStockGroupParagraph($strGroupId, false, $strMemberId, $strLoginId);
    }
    else if ($strSymbol = UrlGetQueryValue('symbol'))
    {	// in pages like mystock
    	EchoAllStockGroupParagraph(false, SqlGetStockId($strSymbol), $strMemberId, $strLoginId);
    }
    else
    {
    	EchoAllStockGroupParagraph(false, false, $strMemberId, $strLoginId);
    }
}

?>
