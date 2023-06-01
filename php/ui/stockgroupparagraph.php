<?php
require_once('stocktable.php');

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

function _echoStockGroupTableItem($strGroupId, $acct, $bReadOnly, $bAdmin)
{
	$strGroupName = $acct->GetGroupName($strGroupId);
    $strEdit = '';
    $strDelete = GetDeleteLink(STOCK_PATH.'submitgroup.php?delete='.$strGroupId, $strGroupName.'股票分组和相关交易记录');
    if ($bReadOnly)
    {
    	if ($bAdmin == false)	$strDelete = '';
    }
    else
    {
    	$strEdit = GetEditLink(STOCK_PATH.'editstockgroup', $strGroupId);
    	if ($bAdmin)				 $strDelete = GetDeleteLink('/php/_submitdelete.php?groupname='.$strGroupName, '全部名称为'.$strGroupName.'的股票分组');
    }

    $ar = array();
    $ar[] = $acct->GetGroupLink($strGroupId);
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

function _echoStockGroupTableData($acct, $strStockId, $strMemberId, $bAdmin)
{
	$bReadOnly = $acct->IsReadOnly();
    $iTotal = 0;
	$sql = $acct->GetGroupSql();
	if ($result = $sql->GetAll($strMemberId)) 
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
			$strGroupId = $record['id'];
			if (($strStockId == false) || SqlGroupHasStock($strGroupId, $strStockId))
			{
				_echoStockGroupTableItem($strGroupId, $acct, $bReadOnly, $bAdmin);
				$iTotal ++;
			}
		}
		mysqli_free_result($result);
	}

	if ($strStockId && $iTotal == 0)
	{
		_echoNewStockGroupTableItem($strStockId, $strMemberId);
	}
}

function EchoStockGroupParagraph($acct, $strGroupId = false, $strStockId = false)
{
	EchoTableParagraphBegin(array(new TableColumnGroupName(),
								   new TableColumnSymbol(false, 450),
								   new TableColumn()
								   ), TABLE_STOCK_GROUP, GetMyStockGroupLink());


	$bAdmin = $acct->IsAdmin();
	if ($strGroupId)
	{
		_echoStockGroupTableItem($strGroupId, $acct, $acct->IsGroupReadOnly($strGroupId), $bAdmin);
	}
	else
	{
   		if ($strMemberId = $acct->GetMemberId())
    	{
    		_echoStockGroupTableData($acct, $strStockId, $strMemberId, $bAdmin);
    	}
    	else
    	{
    		_echoNewStockGroupTableItem($strStockId);
    	}
	}
    EchoTableParagraphEnd();
}

?>
