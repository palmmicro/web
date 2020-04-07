<?php

function GetYahooComponentsUrl($strYahooSymbol = '%5EDJI')
{
   	return YahooStockGetUrl($strYahooSymbol).'/components';
}

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

// http://data.cnstock.com/thematic/szAbShare.html
// http://data.cnstock.com/thematic/shAbShare.html
function GetCnstocksUrl($strType = 'sh')
{
	return 'http://data.cnstock.com/thematic/'.$strType.'AbShare.html';
}

function GetXueqiuUrl()
{
	return 'https://xueqiu.com/';
}

function GetJisiluDataUrl()
{
	return 'https://www.jisilu.cn/data/';
}

function GetJiaShiFundUrl()
{
	return 'http://www.jsfund.cn';
}

function GetGuoTaiFundUrl()
{
	return 'https://e.gtfund.com';
}

function GetEFundUrl()
{
	return 'http://www.efunds.com.cn';
}

?>
