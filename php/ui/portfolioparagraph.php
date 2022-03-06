<?php
require_once('stocktable.php');

function _getPortfolioTestVal($iShares, $strSymbol)
{
	switch ($strSymbol)
    {
/*	
	case 'SH600104':
		$iQuantity = 4000;
		break;

    case 'SZ160717':
    	$iQuantity = 41200;
    	break;
*/  		
	case 'KWEB':
		$iQuantity = 600;
		break;

    case 'SZ162411':
		$iQuantity = 129000 + 2 * 140000;
		break;
		
	default:
		$iQuantity = 0;
		break;
	}
	return $iShares - $iQuantity;
}

function _getArbitrageTestStr($iShares, $strGroupId, $strStockId, $strSymbol)
{
	$iArbitrageQuantity = 0;
	$item_sql = new StockGroupItemSql($strGroupId);
	if ($result = $item_sql->GetAll()) 
	{   
		while ($record = mysql_fetch_assoc($result)) 
		{
			if ($strStockId != $record['stock_id'])
			{
				$iArbitrageQuantity = intval($record['quantity']);
				break;
			}
		}
        @mysql_free_result($result);
    }

    $iQuantity = _getPortfolioTestVal($iShares, $strSymbol); 
    $str = strval($iQuantity).'/';
    $str .= strval($iArbitrageQuantity + $iQuantity * GetArbitrageRatio(SqlGetStockSymbol($record['stock_id'])));
    return $str;
}

function _echoPortfolioTableItem($trans)
{
	$ar = array();
	
    $ref = $trans->ref;
    $strSymbol = $ref->GetSymbol();
    
    $strGroupId = $trans->GetGroupId();
    $ar[] = StockGetTransactionLink($strGroupId, $strSymbol);
    $ar[] = $trans->GetProfitDisplay();
    $iShares = $trans->GetTotalShares();
    if ($iShares != 0)
    {
        $ar[] = GetNumberDisplay($trans->GetValue());
        $ar[] = strval($iShares); 
        $ar[] = $trans->GetAvgCostDisplay();
       	$ar[] = ($trans->GetTotalCost() > 0.0) ? $ref->GetPercentageDisplay($trans->GetAvgCost()) : '';
        switch ($strSymbol)
        {
/*		
        case 'SH600104':
        case 'SZ160717':
*/
		case 'KWEB':
		case 'XLE':
        	$ar[] = _getArbitrageTestStr($iShares, $strGroupId, $ref->GetStockId(), $strSymbol);
        	break;
    		
		case 'SZ162411':
        	$ar[] = strval(_getPortfolioTestVal($iShares, $strSymbol));
        	break;
    		
        case 'SZ161127':
        case 'SZ163208':
        case 'SZ164906':
        	$ar[] = GetArbitrageQuantity($strSymbol, floatval($iShares));
			break;
   		}
    }

    RefEchoTableColumn($ref, $ar);
}

function EchoPortfolioParagraph($arTrans)
{
	$profit_col = new TableColumnProfit();
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   $profit_col,
								   new TableColumnHolding(),
								   new TableColumnTotalShares(),
								   new TableColumnPrice('平均'),
								   new TableColumnChange(),
								   new TableColumnTest()
								   ), 'myportfolio', '个股'.$profit_col->GetDisplay());

	foreach ($arTrans as $trans)
	{
		if ($trans->GetTotalRecords() > 0)	_echoPortfolioTableItem($trans);
	}
    EchoTableParagraphEnd();
}

?>
