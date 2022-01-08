<?php
require_once('stocktable.php');

function _echoPortfolioTableItem($trans)
{
	$ar = array();
	
    $ref = $trans->ref;
    $strSymbol = $ref->GetSymbol();
    
    $ar[] = StockGetTransactionLink($trans->GetGroupId(), $strSymbol);
    $ar[] = $trans->GetProfitDisplay().$ref->GetMoneyDisplay();
    $iShares = $trans->GetTotalShares();
    if ($iShares != 0)
    {
        $ar[] = GetNumberDisplay($trans->GetValue());
        $ar[] = strval($iShares); 
        $ar[] = $trans->GetAvgCostDisplay();
        if ($trans->GetTotalCost() > 0.0)
        {
        	$ar[] = $ref->GetPercentageDisplay($trans->GetAvgCost());
        }
        else
        {
        	$ar[] = '';
        }

        switch ($strSymbol)
        {
        case 'SZ162411':
        	$ar[] = strval($iShares - 269000 - 5 * 140000);
        	break;
    		
        case 'SZ164906':
        	$ar[] = GetArbitrageQuantity($strSymbol, floatval($iShares));
			break;
    		
/*		case 'KWEB':
        	$ar[] = strval($iShares - 400);
			break;

        case 'SH600104':
        	$ar[] = strval($iShares - 4000);
			break;
*/
   		}
    }

    EchoTableColumn($ar);
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
								   ), MY_PORTFOLIO_PAGE, '个股'.$profit_col->GetDisplay());

	foreach ($arTrans as $trans)
	{
		if ($trans->GetTotalRecords() > 0)
		{
			_echoPortfolioTableItem($trans);
		}
	}
    EchoTableParagraphEnd();
}

?>
