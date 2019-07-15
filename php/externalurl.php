<?php

function GetSinaFinanceUrl()
{
	return 'https://finance.sina.com.cn/';
}

function GetSinaUsStockListUrl()
{
	return 'http://vip.stock.finance.sina.com.cn/usstock/ustotal.php';
}

function GetEastMoneyFundUrl()
{
	return 'http://fund.eastmoney.com/';
}

function GetEastMoneyFundListUrl()
{
	return GetEastMoneyFundUrl().'allfund.html';
}

function GetEastMoneyStockListUrl()
{
	return 'http://quote.eastmoney.com/stock_list.html';
}

// http://bond.jrj.com.cn/data/gz.shtml
// http://bond.jrj.com.cn/data/qz.shtml
// http://bond.jrj.com.cn/data/kzz.shtml
function GetJrjBondListUrl($strType = 'gz')
{
	return 'http://bond.jrj.com.cn/data/'.$strType.'.shtml';
}

// http://www.aastocks.com/tc/market/adr.aspx
// http://www.aastocks.com/tc/market/ah.aspx
function GetAastocksUrl($strType = 'adr')
{
	return 'http://www.aastocks.com/tc/market/'.$strType.'.aspx';
}

function GetXueqiuUrl()
{
	return 'https://xueqiu.com/';
}

function GetJisiluDataUrl()
{
	return 'https://www.jisilu.cn/data/';
}

?>
