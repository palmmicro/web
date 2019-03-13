<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/ui/htmlelement.php');

define('STOCK_OPTION_ADJCLOSE', 'AdjClose by Dividend');
define('STOCK_OPTION_ADJCLOSE_CN', '根据分红更新复权收盘价');

define('STOCK_OPTION_ADR', 'ADR Stock Pair');
define('STOCK_OPTION_ADR_CN', '修改港股对应ADR代码');

define('STOCK_OPTION_AH', 'AH Stock Pair');
define('STOCK_OPTION_AH_CN', '修改H股对应A股代码');

define('STOCK_OPTION_ETF', 'ETF Pair');
define('STOCK_OPTION_ETF_CN', '修改ETF对应跟踪代码');

define('STOCK_OPTION_EMA', 'EMA 200/50');
define('STOCK_OPTION_EMA_CN', '修改200/50天EMA');

define('STOCK_OPTION_SPLIT', 'Split Stock');
define('STOCK_OPTION_SPLIT_CN', '拆股或合股');

define('STOCK_OPTION_EDIT', 'Edit Stock Description');
define('STOCK_OPTION_EDIT_CN', '修改股票说明');

define('STOCK_OPTION_AMOUNT', 'Amount of Fund Purchase');
define('STOCK_OPTION_AMOUNT_CN', '设置基金申购金额');

function _getStockOptionSymbol($strSubmit)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADJCLOSE_CN:
	case STOCK_OPTION_ADJCLOSE:
	case STOCK_OPTION_AMOUNT_CN:
	case STOCK_OPTION_AMOUNT:
		return UrlGetQueryValue('symbol');

	case STOCK_OPTION_ADR_CN:
	case STOCK_OPTION_ADR:
		return UrlGetQueryValue('adr');

	case STOCK_OPTION_AH_CN:
	case STOCK_OPTION_AH:
		return UrlGetQueryValue('ah');

	case STOCK_OPTION_EMA_CN:
	case STOCK_OPTION_EMA:
		return UrlGetQueryValue('ema');

	case STOCK_OPTION_ETF_CN:
	case STOCK_OPTION_ETF:
		return UrlGetQueryValue('etf');

	case STOCK_OPTION_EDIT_CN:
	case STOCK_OPTION_EDIT:
		return UrlGetQueryValue('edit');

	case STOCK_OPTION_SPLIT_CN:
	case STOCK_OPTION_SPLIT:
		return UrlGetQueryValue('split');
	}
	return false;
}

function _getStockOptionDate($strSubmit, $strStockId)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADJCLOSE:
	case STOCK_OPTION_ADJCLOSE_CN:
	case STOCK_OPTION_SPLIT:
	case STOCK_OPTION_SPLIT_CN:
	case STOCK_OPTION_EMA:
	case STOCK_OPTION_EMA_CN:
		$sql = new StockHistorySql($strStockId);
		if ($strDate = $sql->GetDateNow())
		{
			return $strDate;
		}
		break;
	}
	return '';
}

function _getStockOptionDescription($strSubmit, $strSymbol)
{
    $sym = new StockSymbol($strSymbol);
	$ref = StockGetReference($sym);
    $stock = SqlGetStock($strSymbol);
    if ($strSubmit == STOCK_OPTION_EDIT_CN)
    {
        $strDescription = $stock['cn'].'-'.$ref->GetChineseName();
        if ($sym->IsFundA())
        {
            $fund_ref = new FundReference($strSymbol);
            $strDescription .= '-'.$fund_ref->GetChineseName();
        }
    }
    else
    {
        $strDescription = $stock['us'].'-'.$ref->GetEnglishName();
    }
    return $strDescription;
}

function _getStockOptionAmount($strSymbol)
{
   	if ($str = SqlGetFundPurchaseAmount(AcctIsLogin(), SqlGetStockId($strSymbol)))
   	{
    	return $str;
    }
    return FUND_PURCHASE_AMOUNT;
}

function _getStockOptionAdr($strSymbol)
{
	if ($strAdr = SqlGetHadrPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_ADRH_STOCK, SqlGetStockId($strAdr)))
		{
			return $strAdr.'/'.strval($fRatio);
		}
		return $strAdr;
	}
	return 'ADR/100';
}

function _getStockOptionAh($strSymbol)
{
	if ($strA = SqlGetHaPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_AH_STOCK, SqlGetStockId($strA)))
		{
			return $strA.'/'.strval($fRatio);
		}
		return $strA;
	}
	return 'A/1';
}

function _getStockOptionEtf($strSymbol)
{
	SqlCreateStockPairTable(TABLE_ETF_PAIR);
	if ($strIndex = SqlGetEtfPair($strSymbol))
	{
		if ($fRatio = SqlGetStockPairRatio(TABLE_ETF_PAIR, SqlGetStockId($strSymbol)))
		{
			return $strIndex.'*'.strval($fRatio);
		}
		return $strIndex;
	}
	return 'INDEX*1';
}

function _getStockOptionEmaDays($strStockId, $strDate, $iDays)
{
	$sql = new StockEmaSql($strStockId, $iDays);
	return $sql->GetCloseString($strDate);
}

function _getStockOptionEma($strStockId, $strDate)
{
	$str200 = _getStockOptionEmaDays($strStockId, $strDate, 200);
	$str50 = _getStockOptionEmaDays($strStockId, $strDate, 50);
	if ($str200 && $str50)
	{
		return $str200.'/'.$str50;
	}
	return 'EMA200/50';
}

function _getStockOptionVal($strSubmit, $strSymbol, $strStockId, $strDate)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_ADJCLOSE_CN:
	case STOCK_OPTION_ADJCLOSE:
		return '0.01';

	case STOCK_OPTION_ADR_CN:
	case STOCK_OPTION_ADR:
		return _getStockOptionAdr($strSymbol);

	case STOCK_OPTION_AH_CN:
	case STOCK_OPTION_AH:
		return _getStockOptionAh($strSymbol);

	case STOCK_OPTION_EMA_CN:
	case STOCK_OPTION_EMA:
		return _getStockOptionEma($strStockId, $strDate);

	case STOCK_OPTION_ETF_CN:
	case STOCK_OPTION_ETF:
		return _getStockOptionEtf($strSymbol);

	case STOCK_OPTION_EDIT_CN:
	case STOCK_OPTION_EDIT:
		return _getStockOptionDescription($strSubmit, $strSymbol);

	case STOCK_OPTION_SPLIT_CN:
	case STOCK_OPTION_SPLIT:
		return '10:1';

	case STOCK_OPTION_AMOUNT_CN:
	case STOCK_OPTION_AMOUNT:
		return _getStockOptionAmount($strSymbol);
	}
	return '';
}

function _getStockOptionMemo($strSubmit)
{
	switch ($strSubmit)
	{
	case STOCK_OPTION_EMA_CN:
		return '股票收盘后的第2天修改才会生效, 输入0/0删除全部EMA记录.';

	case STOCK_OPTION_ETF_CN:
		return '输入INDEX*0删除对应关系和全部校准记录.';

	case STOCK_OPTION_SPLIT_CN:
		return '输入1:10表示10股合1股, 10:1表示1股拆10股.';

	case STOCK_OPTION_ADR_CN:
	case STOCK_OPTION_AH_CN:
		return '输入SYMBOL/0删除对应关系.';
	}
	return '';
}

function StockOptionEditForm($strSubmit)
{
	$strSymbol = _getStockOptionSymbol($strSubmit);
	if ($strSymbol == false)		return;
	
	$strStockId = SqlGetStockId($strSymbol);
    $strEmail = AcctGetEmail(); 
	$strEmailReadonly = HtmlElementReadonly();
	$strSymbolReadonly = HtmlElementReadonly();
	
    $strDateDisabled = '';
    if (($strDate = _getStockOptionDate($strSubmit, $strStockId)) == '')
    {
    	$strDateDisabled = HtmlElementDisabled();
    }
    
    $strVal = _getStockOptionVal($strSubmit, $strSymbol, $strStockId, $strDate);
    $strMemo = _getStockOptionMemo($strSubmit);
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	    }
	</script>
	
	<form id="stockoptionForm" name="stockoptionForm" method="post" action="/woody/res/php/_submitstockoptions.php">
        <div>
		<p><font color=blue>$strMemo</font>
		<br /><input name="login" value="$strEmail" type="text" size="40" maxlength="128" class="textfield" id="login" $strEmailReadonly />
		<br /><input name="symbol" value="$strSymbol" type="text" size="20" maxlength="32" class="textfield" id="symbol" $strSymbolReadonly />
		<br /><input name="date" value="$strDate" type="text" size="10" maxlength="32" class="textfield" id="date" $strDateDisabled />
		<br /><textarea name="val" rows="8" cols="75" id="val">$strVal</textarea>
	    <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
	    </div>
    </form>
END;
}

?>
