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

function GetBoShiFundUrl()
{
	return 'http://www.bosera.com';
}

function GetHuaBaoFundUrl()
{
	return 'http://www.fsfund.com';
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

function GetXinChengFundUrl()
{
	return 'http://www.citicprufunds.com.cn';
}

function GetYinHuaFundUrl()
{
	return 'http://www.yhfund.com.cn';
}

// https://www.ssga.com/us/en/individual/etfs/library-content/products/fund-data/etfs/us/navhist-us-en-xop.xlsx
function GetSpdrNavUrl($strSymbol)
{
	$sql = new StockSql();
	$record = $sql->GetRecord($strSymbol);
   	if (stripos($record['name'], 'spdr') !== false)
	{
		return 'https://www.ssga.com/us/en/individual/etfs/library-content/products/fund-data/etfs/us/navhist-us-en-'.strtolower($strSymbol).'.xlsx';
	}
	return false;
}

function GetMacroTrendsUrl()
{
	return 'https://www.macrotrends.net';
}

function GetCmeTradingUrl()
{
	return 'https://www.cmegroup.com/trading/';
}


?>
