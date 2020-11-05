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

function _transSortBySymbol($arTrans)
{
    $ar = array();
    foreach ($arTrans as $trans)
    {
    	$ref = $trans->GetRef();
        $strSymbol = $ref->GetSymbol();
        if (isset($ar[$strSymbol]))
        {
        	array_push($ar[$strSymbol], $trans);
        }
        else
        {
        	$ar[$strSymbol] = array($trans);
        }
    }
    ksort($ar);
    
    $arSort = array();
    foreach ($ar as $str => $arTrans)
    {
        $arSort = array_merge($arSort, $arTrans);
    }
    return $arSort;
}

function _transEchoReferenceParagraph($arTrans)
{
	$arRef = array();
	$arSymbol = array();
	
	foreach ($arTrans as $trans)
	{
		$ref = $trans->GetRef();
		$strSymbol = $ref->GetSymbol();
       	if (!in_array($strSymbol, $arSymbol))
       	{
       		$arRef[] = $ref;
       		$arSymbol[] = $strSymbol;
       	}
	}
	
	// Stock history update
	foreach ($arRef as $ref)
	{
		$his = new StockHistory($ref);
	}
	
    EchoReferenceParagraph($arRef);
}

function _echoMergeParagraph($arMerge)
{
	EchoTableParagraphBegin(array(new TableColumnSymbol(),
								   new TableColumnTotalShares(),
								   new TableColumnTest()
								   ), 'merge', '合并数量');

	foreach ($arMerge as $strSymbol => $trans)
	{
		$ar = array();
		
		$ref = $trans->GetRef();
		if ($ref->IsSymbolUS())	$ar[] = GetTradingViewLink($strSymbol);
		else						$ar[] = RefGetMyStockLink($ref);
			
		$iTotal = $trans->GetTotalShares();
        $ar[] = strval($iTotal);
        if ($strSymbol == 'XOP')
        {
        	$ar[] = strval($iTotal - 514);
        }
        EchoTableColumn($ar);
	}
    EchoTableParagraphEnd();
}

function _transEchoMergeParagraph($arTrans)
{
	$arMerge = array();
	$arSymbol = array();
	$prev_trans = false;
	$cur_trans = false;
	
	foreach ($arTrans as $trans)
	{
		$strSymbol = $trans->GetSymbol();
       	if (in_array($strSymbol, $arSymbol))
       	{
       		if ($cur_trans == false)
       		{
       			$cur_trans = new MyStockTransaction($trans->GetRef());
       			$cur_trans->Add($prev_trans);
       		}
   			$cur_trans->Add($trans);
       	}
       	else
       	{
       		$arSymbol[] = $strSymbol;
       		if ($cur_trans)
       		{
       			$strPrevSymbol = $prev_trans->GetSymbol();
       			$arMerge[$strPrevSymbol] = $cur_trans;
       			$cur_trans = false;
       		}
       		$prev_trans = $trans;
       	}
	}

	if ($cur_trans)
	{
		$arMerge[$strSymbol] = $cur_trans;
	}
	
	if (count($arMerge) > 0)		_echoMergeParagraph($arMerge);
}

function _echoPortfolio($portfolio, $sql)
{
	$arTransA = array();
	$arTransH = array();
	$arTransUS = array();

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
		                
		                $ref = $trans->GetRef();
		                if ($ref->IsSymbolA())	       	$arTransA[] = $trans;
		                else if ($ref->IsSymbolH())      	$arTransH[] = $trans;
		                else			                	$arTransUS[] = $trans;
		            }
		        }
		    }
		}
		@mysql_free_result($result);
	}

	$arTrans = array_merge(_transSortBySymbol($arTransA), _transSortBySymbol($arTransH), _transSortBySymbol($arTransUS));
    _transEchoReferenceParagraph($arTrans);
	EchoPortfolioParagraph('个股盈亏', $arTrans);
    _transEchoMergeParagraph($arTrans);
}

function _echoMoneyParagraph($portfolio)
{
    $strUSDCNY = SqlGetUSCNY();
    $strHKDCNY = SqlGetHKCNY();    

    _EchoMoneyParagraphBegin();
    foreach ($portfolio->arStockGroup as $group)
    {
        _EchoMoneyGroupData($group, $strUSDCNY, $strHKDCNY);
    }
    _EchoMoneyGroupData($portfolio, $strUSDCNY, $strHKDCNY, DISP_ALL_CN);
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
    
    $acct->EchoLinks(MY_PORTFOLIO_PAGE);
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

	$acct = new StockAccount();
	if ($acct->GetMemberId() == false)
	{
		$acct->Auth();
	}

?>

