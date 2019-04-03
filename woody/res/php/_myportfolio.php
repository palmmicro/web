<?php
require_once('_stock.php');
require_once('/php/stockhis.php');
//require_once('/php/stockgroup.php');
require_once('/php/ui/referenceparagraph.php');

class _MyPortfolio extends StockGroup
{
    var $arStockGroup = array();
    
    function _MyPortfolio() 
    {
        parent::StockGroup();
    }
}

function _echoPortfolio($portfolio, $sql)
{
    $arRef = array();
    _EchoPortfolioParagraphBegin('个股盈亏');    
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
		    $group = new MyStockGroup($record['id'], array());
		    if ($group->GetTotalRecords() > 0)
		    {
		        $portfolio->arStockGroup[] = $group;
		        foreach ($group->arStockTransaction as $trans)
		        {
		            if ($trans->iTotalRecords > 0)
		            {
		                _EchoPortfolioItem($record['id'], $trans);
		                $portfolio->OnStockTransaction($trans);
		                if (!in_array($trans->ref, $arRef))    $arRef[] = $trans->ref;
		            }
		        }
		    }
		}
		@mysql_free_result($result);
	}
    EchoTableParagraphEnd();    

    StockHistoryUpdate($arRef);    
    $arRef = RefSortBySymbol($arRef);
    foreach ($arRef as $ref)
    {
    	RefSetExternalLinkMyStock($ref);
    }
    EchoReferenceParagraph($arRef);
}

function _echoMoneyParagraph($portfolio)
{
    $fUSDCNY = SqlGetUSCNY();
    $fHKDCNY = SqlGetHKCNY();    

    _EchoMoneyParagraphBegin();
    foreach ($portfolio->arStockGroup as $group)
    {
        _EchoMoneyGroupData($group, GetStockGroupLink($group->GetGroupId()), $fUSDCNY, $fHKDCNY);
    }
    _EchoMoneyGroupData($portfolio, '全部', $fUSDCNY, $fHKDCNY);
    EchoTableParagraphEnd();
}

function _onPrefetch($sql) 
{
	if ($result = $sql->GetAll()) 
	{
	    $arSymbol = array();
		while ($record = mysql_fetch_assoc($result)) 
		{
		    $arSymbol = array_merge($arSymbol, SqlGetStocksArray($record['id'], true));
		}
		@mysql_free_result($result);
	}
    StockPrefetchArrayData($arSymbol);
}

function EchoMyFortfolio($bChinese = true)
{
	$sql = new StockGroupSql(AcctGetMemberId());
    _onPrefetch($sql);

    $portfolio = new _MyPortfolio();
    _echoPortfolio($portfolio, $sql);
    _echoMoneyParagraph($portfolio);
    
    EchoPromotionHead('portfolio');
}

    AcctEmailAuth();

?>

