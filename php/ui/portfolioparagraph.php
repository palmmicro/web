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
        
/*        if ($strSymbol == 'CHU')
        {
//        	$ar[] = strval($iShares - 800);
        }
       else if ($strSymbol == 'SH600104')
        {
        	$ar[] = strval($iShares - 4000);
        }*/
    }

    EchoTableColumn($ar);
}

function EchoPortfolioParagraph($str, $arTrans)
{
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnProfit(),
								   new TableColumnHolding(),
								   new TableColumnTotalShares(),
								   new TableColumnPrice('平均'),
								   new TableColumnChange(),
//								   new TableColumnTest()
								   ), MY_PORTFOLIO_PAGE, $str);

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
