<?php
require_once('_stock.php');
require_once('/php/stockgroup.php');
require_once('/php/stockhis.php');
require_once('/php/ui/referenceparagraph.php');

class _MyPortfolio extends StockGroup
{
    var $arStockGroup = array();
    
    function _MyPortfolio() 
    {
        parent::StockGroup();
    }
}

function _echoReference($arRef)
{
	$arA = array();
	$arH = array();
	$arUS = array();
	
    StockHistoryUpdate($arRef);    
    $arRef = RefSortBySymbol($arRef);
    foreach ($arRef as $ref)
    {
    	RefSetExternalLinkMyStock($ref);
    	if ($ref->IsSymbolA())		$arA[] = $ref;
    	else if ($ref->IsSymbolH())	$arH[] = $ref;
    	else							$arUS[] = $ref;
    }
    EchoReferenceParagraph(array_merge($arA, $arH, $arUS));
}

function _echoPortfolio($portfolio, $sql)
{
	$arTrans = array();
    $arRef = array();

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
		            if ($trans->GetTotalRecords() > 0)
		            {
		                $portfolio->OnStockTransaction($trans);
		                $arTrans[] = $trans;
		                
		                $ref = $trans->GetRef();
		                if (!in_array($ref, $arRef))    $arRef[] = $ref;
		            }
		        }
		    }
		}
		@mysql_free_result($result);
	}

    _echoReference($arRef);
	EchoPortfolioParagraph('个股盈亏', $arTrans);
}

function _echoMoneyParagraph($portfolio)
{
    $strUSDCNY = SqlGetUSCNY();
    $strHKDCNY = SqlGetHKCNY();    

    _EchoMoneyParagraphBegin();
    foreach ($portfolio->arStockGroup as $group)
    {
        _EchoMoneyGroupData($group, GetStockGroupLink($group->GetGroupId()), $strUSDCNY, $strHKDCNY);
    }
    _EchoMoneyGroupData($portfolio, STOCK_DISP_ALL, $strUSDCNY, $strHKDCNY);
    EchoTableParagraphEnd();
}

function _onPrefetch($sql) 
{
    $arSymbol = array();
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
		    $arSymbol = array_merge($arSymbol, SqlGetStocksArray($record['id'], true));
		}
		@mysql_free_result($result);
	}
    StockPrefetchArrayData($arSymbol);
}

function EchoAll()
{
	global $acct;
	
	$sql = new StockGroupSql($acct->GetMemberId());
    _onPrefetch($sql);

    $portfolio = new _MyPortfolio();
    _echoPortfolio($portfolio, $sql);
    _echoMoneyParagraph($portfolio);
    
    EchoPromotionHead(MY_PORTFOLIO_PAGE);
    EchoStockCategory();
}

function EchoTitle()
{
    echo '我的'.MY_PORTFOLIO_DISPLAY;
}

function EchoMetaDescription()
{
    $str = '证券投资组合汇总页面. 根据用户输入的交易详情汇总信息, 显示包括单个股票的盈亏情况, 分组投资盈亏情况以及总体盈亏情况等内容. 用来跟踪和记录自己的长期投资表现.';
    EchoMetaDescriptionText($str);
}

	$acct = new AcctStart();
	if ($acct->GetMemberId() == false)
	{
		$acct->Auth();
	}

?>

