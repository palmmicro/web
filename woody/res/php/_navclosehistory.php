<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

class PriceGoal
{
    var $iTotal;
    
    var $iHigher;
    var $iUnchanged;
    var $iLower;

    function PriceGoal() 
    {
        $this->iTotal = 0;
        
        $this->iHigher = 0;
        $this->iUnchanged = 0;
        $this->iLower = 0;
    }
    
    function AddData($fVal)
    {
   		if (empty($fVal))
   		{
   			$this->iUnchanged ++;
   		}
   		else if ($fVal > 0.0)
    	{
    		$this->iHigher ++;
    	}
    	else
    	{
    		$this->iLower ++;
    	}
        $this->iTotal ++;
    }
}

class PricePool
{
	var $h_goal;
	var $u_goal;
	var $l_goal;

    function PricePool() 
    {
        $this->h_goal = new PriceGoal();
        $this->u_goal = new PriceGoal();
        $this->l_goal = new PriceGoal();
    }
    
    function OnData($fVal, $fCompare)
    {
    	if (empty($fVal))
    	{
   			$this->u_goal->AddData($fCompare);
    	}
    	else if ($fVal > 0.0)
    	{
   			$this->h_goal->AddData($fCompare);
    	}
    	else
    	{
  			$this->l_goal->AddData($fCompare);
     	}
    }
}

function _echoPricePoolItem($str, $goal)
{
    $strTotal = strval($goal->iTotal);
    $strHigher = strval($goal->iHigher);
    $strUnchanged = strval($goal->iUnchanged);
    $strLower = strval($goal->iLower);
    
    echo <<<END
    <tr>
        <td class=c1>$str</td>
        <td class=c1>$strTotal</td>
        <td class=c1>$strHigher</td>
        <td class=c1>$strUnchanged</td>
        <td class=c1>$strLower</td>
    </tr>
END;
}

function _echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol = '', $arColumnEx, $arRow)
{
	$strLink = GetMyStockLink($strSymbol, $bChinese);
    if ($bChinese)	$arColumn = array($strLink.'交易',     '天数');
    else		    	$arColumn = array($strLink.' Trading', 'Days');

    echo <<<END
    <p>
    <TABLE borderColor=#cccccc cellSpacing=0 width=570 border=1 class="text" id="pricepool">
    <tr>
        <td class=c1 width=150 align=center>{$arColumn[0]}</td>
        <td class=c1 width=60 align=center>{$arColumn[1]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[0]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[1]}</td>
        <td class=c1 width=120 align=center>{$strTradingSymbol}{$arColumnEx[2]}</td>
    </tr>
END;

    _echoPricePoolItem($arRow[0], $pool->h_goal);
    _echoPricePoolItem($arRow[1], $pool->u_goal);
    _echoPricePoolItem($arRow[2], $pool->l_goal);
    EchoTableParagraphEnd();
}

function EchoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol = '', $bTranspose = false)
{
    if ($bChinese)
    {
    	$arColumnEx = array('涨', '不变', '跌');
    	$arRow = array('溢价', '平价', '折价');
    }
    else
    {
    	$arColumnEx = array(' Higher', ' Unchanged', ' Lower');
    	$arRow = array('Higher', 'Unchanged', 'Lower');
    }
    
    if ($bTranspose)
    {
    	_echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol, $arRow, $arColumnEx);
    }
    else
    {
    	_echoPricePoolParagraph($pool, $bChinese, $strSymbol, $strTradingSymbol, $arColumnEx, $arRow);
    }
}

class _NavCloseCsvFile extends PageCsvFile
{
	var $pool;
	var $t_pool;
	
    function _NavCloseCsvFile() 
    {
        parent::PageCsvFile();
        $this->pool = new PricePool();
        $this->t_pool = new PricePool();
    }

    function OnLineArray($arWord)
    {
    	$fClose = floatval($arWord[2]);
    	$fNav = floatval($arWord[3]);
    	$this->pool->OnData($fNav, $fClose);
    	$this->t_pool->OnData($fClose, $fNav);
    }
}

function _echoNavClosePool($strSymbol, $bChinese)
{
   	$csv = new _NavCloseCsvFile();
   	$csv->Read();
   	EchoPricePoolParagraph($csv->pool, $bChinese, $strSymbol);
   	EchoPricePoolParagraph($csv->t_pool, $bChinese, $strSymbol, '', true);
}

function _echoNavCloseGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(3));
    $jpg->DrawCompareArray($csv->ReadColumn(1));
	$strPremium = $bChinese ? '溢价' : 'Premium';
    $jpg->Show($strPremium, $strSymbol, $csv->GetPathName());
}

function _echoNavCloseItem($csv, $strDate, $fNetValue, $ref, $strFundId)
{
	$fClose = $ref->GetCurrentPrice();
    $strClose = StockGetPriceDisplay($fClose, $fNetValue);
    $strStockPercentage = $ref->GetCurrentPercentageDisplay();
    $strNetValue = strval($fNetValue);
    
    if (abs($fClose - $fNetValue) > 0.005)
    {
    	$strPercentage = StockGetPercentageDisplay($fClose, $fNetValue);
    	$fPercentage = StockGetPercentage($fClose, $fNetValue);
    }
    else
    {
    	$strPercentage = '';
    	$fPercentage = 0.0;
    }
	$csv->WriteArray(array($strDate, $strNetValue, strval($ref->GetCurrentPercentage()), strval($fPercentage)));
    
    if ($strFundId)
    {
    	$strNetValue = GetOnClickLink('/php/_submitdelete.php?'.TABLE_FUND_HISTORY.'='.$strFundId, '确认删除'.$strDate.'净值记录'.$strNetValue.'?', $strNetValue);
    }
    
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strNetValue</td>
        <td class=c1>$strPercentage</td>
        <td class=c1>$strStockPercentage</td>
    </tr>
END;
}

function _echoNavCloseData($sql, $ref, $iStart, $iNum, $bTest)
{
	$clone_ref = clone $ref;
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
     	$csv = new PageCsvFile();
        while ($arFund = mysql_fetch_assoc($result)) 
        {
        	$fNetValue = floatval($arFund['close']);
        	if (empty($fNetValue) == false)
        	{
        		$strDate = $arFund['date'];
       			if ($stock_ref = RefGetDailyClose($clone_ref, $sql->stock_sql, $strDate))
       			{
       				_echoNavCloseItem($csv, $strDate, $fNetValue, $stock_ref, ($bTest ? $arFund['id'] : false));
        		}
        	}
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoNavCloseParagraph($strSymbol, $strStockId, $iStart, $iNum, $bChinese)
{
    // StockPrefetchData($strSymbol);
    $ref = new MyStockReference($strSymbol);
    $arColumn = GetFundHistoryTableColumn($ref, $bChinese);
    
	$sql = new FundHistorySql($strStockId);
    $strNavLink = StockGetNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);

    echo <<<END
    <p>$strNavLink
    <TABLE borderColor=#cccccc cellSpacing=0 width=500 border=1 class="text" id="navclosehistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=100 align=center>{$arColumn[4]}</td>
        <td class=c1 width=100 align=center>{$arColumn[2]}</td>
        <td class=c1 width=100 align=center>{$arColumn[3]}</td>
        <td class=c1 width=100 align=center>{$arColumn[5]}</td>
    </tr>
END;
   
    _echoNavCloseData($sql, $ref, $iStart, $iNum, AcctIsTest($bChinese));
    EchoTableParagraphEnd($strNavLink);

    _echoNavClosePool($strSymbol, $bChinese);
    _echoNavCloseGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
   			$iStart = UrlGetQueryInt('start');
   			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   			_echoNavCloseParagraph($strSymbol, $strStockId, $iStart, $iNum, $bChinese);
    	}
    }
    EchoPromotionHead($bChinese);
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '净值和收盘价历史比较' : ' NAV Close History Compare');
}

    AcctAuth();

?>
