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

function GetHuaAnFundUrl()
{
	return 'http://www.huaan.com.cn';
}

function GetHuaBaoFundUrl()
{
	return 'http://www.fsfund.com';
}

function GetJiaShiFundUrl()
{
	return 'http://www.jsfund.cn';
}

function GetJiaoYinSchroderFundUrl()
{
	return 'https://www.fund001.com/';
}

function GetGuangFaFundUrl()
{
	return 'http://www.gffunds.com.cn';
}

function GetGuoTaiFundUrl()
{
	return 'https://e.gtfund.com';
}

function GetHuaXiaFundUrl()
{
	return 'http://www.chinaamc.com/';
}

function GetEFundUrl()
{
	return 'http://www.efunds.com.cn';
}

function GetNanFangFundUrl()
{
	return 'http://www.nffund.com/';
}

function GetNuoAnFundUrl()
{
	return 'https://trade.lionfund.com.cn/pc/';
}

function GetPenghuaFundUrl()
{
	return 'https://www.phfund.com.cn/';
}

function GetXinChengFundUrl()
{
	return 'http://www.citicprufunds.com.cn';
}

function GetYinHuaFundUrl()
{
	return 'http://www.yhfund.com.cn';
}

// http://www.csindex.com.cn/zh-CN/indices/index-detail/H11136
// http://www.csindex.com.cn/uploads/file/autofile/closeweight/H11136closeweight.xls?t=1625908087
function GetCsindexUrl($strSymbol)
{
	return 'http://www.csindex.com.cn/zh-CN/indices/index-detail/'.$strSymbol;
}

// https://kraneshares.com/kweb/
// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function GetKraneUrl()
{
	return 'https://kraneshares.com/';
}

function GetSpdrEtfUrl()
{
	return 'https://www.ssga.com/us/en/individual/etfs/';
}

// https://www.ishares.com/us/products/239517/ishares-us-oil-gas-exploration-production-etf/
function GetIsharesEtfUrl($strSymbol)
{
	$str = 'https://www.ishares.com/us/products/';
	switch ($strSymbol)
	{
	case 'GSG':
		$str .= '239757/GSG';
		break;

	case 'IEO':
		$str .= '239517/ishares-us-oil-gas-exploration-production-etf';
		break;
		
	case 'IXC':
		$str .= '239741/ishares-global-energy-etf';
		break;
	}
	return $str;
}

// https://www.ishares.com/us/products/239517/ishares-us-oil-gas-exploration-production-etf/1521942788811.ajax?fileType=xls&fileName=iShares-US-Oil--Gas-Exploration--Production-ETF_fund&dataType=fund
function _getIsharesXlsUrl($strSymbol)
{
	$str = GetIsharesEtfUrl($strSymbol).'/';
	switch ($strSymbol)
	{
	case 'GSG':
		break;

	case 'IEO':
		$str .= '1521942788811.ajax?fileType=xls&fileName=iShares-US-Oil--Gas-Exploration--Production-ETF_fund&dataType=fund';
		return $str;
		
	case 'IXC':
		break;
	}
	return false;
}

// https://www.ssga.com/us/en/individual/etfs/library-content/products/fund-data/etfs/us/navhist-us-en-xop.xlsx
function GetEtfNavUrl($strSymbol)
{
	if ($strName = SqlGetStockName($strSymbol))
	{
		if (stripos($strName, 'spdr') !== false)
		{
			return GetSpdrEtfUrl().'library-content/products/fund-data/etfs/us/navhist-us-en-'.strtolower($strSymbol).'.xlsx';
		}
		else if (stripos($strName, 'ishares') !== false)
		{
			return _getIsharesXlsUrl($strSymbol);
		}
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
