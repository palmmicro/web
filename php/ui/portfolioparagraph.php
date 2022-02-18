<?php
require_once('stocktable.php');

function _getPortfolioTestVal($strSymbol)
{
	switch ($strSymbol)
    {
/*	case 'KWEB':
		return 400;

	case 'SH600104':
		return 4000;

    case 'SZ160717':
    	return 41200;
*/  		
    case 'SZ162411':
		return 129000 + 4 * 140000;
	}
	return 0;
}

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
       	$ar[] = ($trans->GetTotalCost() > 0.0) ? $ref->GetPercentageDisplay($trans->GetAvgCost()) : '';
        switch ($strSymbol)
        {
/*		case 'KWEB':
        case 'SH600104':
        case 'SZ160717':
*/
		case 'SZ162411':
        	$ar[] = strval($iShares - _getPortfolioTestVal($strSymbol));
        	break;
    		
        case 'SZ161127':
        case 'SZ164906':
        	$ar[] = GetArbitrageQuantity($strSymbol, floatval($iShares));
			break;
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
