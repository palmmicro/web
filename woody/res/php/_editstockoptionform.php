<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/gb2312.php');
require_once('/php/sql/sqlstock.php');
require_once('/php/ui/htmlelement.php');

define ('STOCK_OPTION_ADJCLOSE_CN', '根据分红更新复权收盘价');

define ('STOCK_OPTION_ADR_CN', '修改ADR代码');

define ('STOCK_OPTION_EDIT', 'Edit Stock Description');
define ('STOCK_OPTION_EDIT_CN', '修改股票说明');

define ('STOCK_OPTION_REVERSESPLIT', 'Reverse Split Stock');
define ('STOCK_OPTION_REVERSESPLIT_CN', '股票合股');

define ('STOCK_OPTION_AMOUNT', 'Set Fund Purchase Amount');
define ('STOCK_OPTION_AMOUNT_CN', '设置基金申购金额');

function _getStockOptionDate($strSubmit, $strSymbol)
{
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT_CN || $strSubmit == STOCK_OPTION_REVERSESPLIT)
	{
		if ($history = SqlGetStockHistoryNow(SqlGetStockId($strSymbol)))
		{
			return $history['date'];
		}
	}
	return '';
}

function _getStockOptionDescription($strSubmit, $strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSinaFund())
    {   // IsSinaFund must be called before IsSinaFuture
    }
    else if ($strFutureSymbol = $sym->IsSinaFuture())		$ref = 	new SinaFutureReference($strFutureSymbol);
    else if ($sym->IsSinaForex())								$ref = 	new SinaForexReference($strSymbol);
    else if ($sym->IsEastMoneyForex())						$ref = new CnyReference($strSymbol);
    else														$ref = new SinaStockReference($strSymbol);
        
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
	return '';
}

function _getStockOptionVal($strSubmit, $strSymbol)
{
	if ($strSubmit == STOCK_OPTION_ADJCLOSE_CN)
	{
		return '0.01';
	}
	else if ($strSubmit == STOCK_OPTION_ADR_CN)
	{
		return _getStockOptionAdr($strSymbol);
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
	$strSymbolReadonly = HtmlElementReadonly();
	
    $strDateDisabled = '';
    if (($strDate = _getStockOptionDate($strSubmit, $strSymbol)) == '')
    {
    	$strDateDisabled = HtmlElementDisabled();
    }
    
    $strVal = _getStockOptionVal($strSubmit, $strSymbol);
	
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
