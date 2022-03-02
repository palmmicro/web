<?php

// https://finance.yahoo.com/quote/XOP/history?period1=1467122442&period2=1498658442&interval=1d&filter=history&frequency=1d
define('YAHOO_STOCK_QUOTES_URL', 'https://finance.yahoo.com/quote/');
function YahooStockHistoryGetUrl($strYahooSymbol, $iTimeBegin = false, $iTimeEnd = false)
{
    $strUrl = YAHOO_STOCK_QUOTES_URL.$strYahooSymbol.'/history';
    if ($iTimeBegin && $iTimeEnd)
    {
    	$strUrl .= '?period1='.strval($iTimeBegin).'&period2='.strval($iTimeEnd).'&interval=1d&filter=history&frequency=1d';
    }
    return $strUrl;
}

function YahooStockGetUrl($strYahooSymbol)
{
	return YAHOO_STOCK_QUOTES_URL.$strYahooSymbol;
}

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

function GetGuoTaiFundUrl()
{
	return 'https://e.gtfund.com';
}

function GetPenghuaFundUrl()
{
	return 'https://www.phfund.com.cn/';
}

function GetYinHuaFundUrl()
{
	return 'http://www.yhfund.com.cn';
}

// https://csi-web-dev.oss-cn-shanghai-finance-1-pub.aliyuncs.com/static/html/csindex/public/uploads/file/autofile/closeweight/H30533closeweight.xls
// https://csi-web-dev.oss-cn-shanghai-finance-1-pub.aliyuncs.com/static/html/csindex/public/uploads/file/autofile/closeweight/H11136closeweight.xls
// https://www.csindex.com.cn/#/indices/family/detail?indexCode=H11136
function GetCsindexUrl($strSymbol)
{
	return 'https://www.csindex.com.cn/#/indices/family/detail?indexCode='.$strSymbol;
}

function GetSzseUrl()
{
	return 'http://www.szse.cn/';
}

function GetSseUrl()
{
	return 'http://www.sse.com.cn/';
}

// https://kraneshares.com/kweb/
// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function GetKraneUrl()
{
	return 'https://kraneshares.com/';
}

// https://www.ssga.com/us/en/individual/etfs/funds/spdr-sp-biotech-etf-xbi
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
function GetEtfNavUrl($sym)
{
	if ($strName = SymGetStockName($sym))
	{
		$strSymbol = $sym->GetSymbol();
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

?>
