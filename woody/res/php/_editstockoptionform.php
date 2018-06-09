<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stock/yahoostockref.php');
require_once('/php/ui/htmlelement.php');

define ('STOCK_OPTION_ADJCLOSE_CN', '根据分红更新复权收盘价');

define ('STOCK_OPTION_ADR_CN', '修改港股对应ADR代码');
define ('STOCK_OPTION_ETF_CN', '修改ETF对应跟踪代码');
define ('STOCK_OPTION_EMA_CN', '修改200/50天EMA');

define ('STOCK_OPTION_EDIT', 'Edit Stock Description');
define ('STOCK_OPTION_EDIT_CN', '修改股票说明');

define ('STOCK_OPTION_REVERSESPLIT', 'Reverse Split Stock');
define ('STOCK_OPTION_REVERSESPLIT_CN', '股票合股');

define ('STOCK_OPTION_AMOUNT', 'Set Fund Purchase Amount');
define ('STOCK_OPTION_AMOUNT_CN', '设置基金申购金额');

function _getStockOptionDate($strSubmit, $strStockId)
{
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT || $strSubmit == STOCK_OPTION_EMA_CN)
	{
		$sql = new StockHistorySql($strStockId);
		if ($strDate = $sql->GetDateNow())
		{
			return $strDate;
		}
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
        $yahoo_ref = new YahooStockReference($strSymbol);
        $strDescription = $stock['us'].'-'.$ref->GetEnglishName().'-'.$yahoo_ref->GetEnglishName();
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
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN)
	{
		return '0.01';
	}
	else if ($strSubmit == STOCK_OPTION_ADR_CN)
	{
		return _getStockOptionAdr($strSymbol);
	}
	else if ($strSubmit == STOCK_OPTION_EMA_CN)
	{
		return _getStockOptionEma($strStockId, $strDate);
	}
	else if ($strSubmit == STOCK_OPTION_ETF_CN)
	{
		return _getStockOptionEtf($strSymbol);
	}
	else if ($strSubmit == STOCK_OPTION_EDIT_CN || $strSubmit == STOCK_OPTION_EDIT)
	{
		return _getStockOptionDescription($strSubmit, $strSymbol);
	}
	else if ($strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT)
	{
		return '10';
	}
	else if ($strSubmit == STOCK_OPTION_AMOUNT_CN || $strSubmit == STOCK_OPTION_AMOUNT)
	{
		return _getStockOptionAmount($strSymbol);
	}
	return '';
}

function StockOptionEditForm($strSubmit)
{
    $strEmail = AcctGetEmail(); 
	$strEmailReadonly = HtmlElementReadonly();
	
	$strSymbol = UrlGetQueryValue('symbol');
	$strStockId = SqlGetStockId($strSymbol);
	$strSymbolReadonly = HtmlElementReadonly();
	
    $strDateDisabled = '';
    if (($strDate = _getStockOptionDate($strSubmit, $strStockId)) == '')
    {
    	$strDateDisabled = HtmlElementDisabled();
    }
    
    $strVal = _getStockOptionVal($strSubmit, $strSymbol, $strStockId, $strDate);
	
	echo <<< END
	<script type="text/javascript">
	    function OnLoad()
	    {
	    }
	</script>
	
	<form id="stockoptionForm" name="stockoptionForm" method="post" action="/woody/res/php/_submitstockoptions.php">
        <div>
		<p><input name="login" value="$strEmail" type="text" size="40" maxlength="128" class="textfield" id="login" $strEmailReadonly />
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
