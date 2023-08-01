<?php
require_once('stocktable.php');

function _getPortfolioTestVal($iShares, $strSymbol)
{
	switch ($strSymbol)
    {
    case 'KWEB':
		$iQuantity = 1114;
		break;
		
    case 'XOP':
		$iQuantity = -153;
		break;

/*    case 'SPY':
		$iQuantity = 100;
		break;
		
	case 'XBI':
		$iQuantity = 0;
		break;
		
    case 'SZ162411':
		$iQuantity = 91200;
		break;
*/		
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
		while ($record = mysqli_fetch_assoc($result)) 
		{
			if ($strStockId != $record['stock_id'])
			{
				$iArbitrageQuantity = intval($record['quantity']);
				if ($iArbitrageQuantity > 0)
				{
//					DebugVal($iArbitrageQuantity, $strSymbol);
					break;
				}
			}
		}
        mysqli_free_result($result);
    }

    if ($record)
    {
    	$iQuantity = _getPortfolioTestVal($iShares, $strSymbol); 
    	return strval($iArbitrageQuantity + $iQuantity * GetArbitrageRatio($record['stock_id']));
    }
    return '';
}

function _echoPortfolioTableItem($trans)
{
	$ar = array();
	
    $ref = $trans->ref;
    $strSymbol = $ref->GetSymbol();
    $strStockId = $ref->GetStockId();
    
    $strGroupId = $trans->GetGroupId();
    $ar[] = StockGetTransactionLink($strGroupId, $strSymbol);
    $ar[] = $trans->GetProfitDisplay();
    $iShares = $trans->GetTotalShares();
    if ($iShares != 0)
    {
        $ar[] = GetNumberDisplay($trans->GetValue());
        $ar[] = strval($iShares); 
        $ar[] = $trans->GetAvgCostDisplay();
       	$ar[] = ($trans->GetTotalCost() > 0.0) ? $ref->GetPercentageDisplay(strval($trans->GetAvgCost())) : '';
        switch ($strSymbol)
        {
		case 'KWEB':
		case 'XBI':
		case 'XOP':
        	$ar[] = _getArbitrageTestStr($iShares, $strGroupId, $strStockId, $strSymbol);
        	break;
   		
/*		case 'SPY':
        	$ar[] = strval(_getPortfolioTestVal($iShares, $strSymbol));
        	break;
*/    		
        case 'SZ161127':
		case 'SZ162411':
        case 'SZ164906':
        	$ar[] = GetArbitrageQuantity($strStockId, floatval($iShares));
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
