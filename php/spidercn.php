<?php
require_once('debug.php');
require_once('url.php');
require_once('weixinstock.php');
require_once('sqlquery.php');

require_once('sql/sqlstock.php');
require_once('sql/sqlvisitor.php');
require_once('sql/sqlspider.php');
require_once('sql/sqlipaddress.php');

function _getSymbolOutput($strSymbol)
{
    $str = $strSymbol.'_net_value=';
    if (StockFundFromCN($strSymbol))
    {
        $ref = WeixinStockGetFundReference($strSymbol);
        $str .= $ref->strPrevPrice.','.$ref->strDate.',';   // T-1 net value;
        if ($ref->strOfficialDate)
        {
            $str .= round_display($ref->fPrice).','.$ref->strOfficialDate.',';  // T net value
        }
        else
        {
            $str .= '0.0,0000-00-00,';
        }
        if ($ref->fFairNetValue)
        {
            $str .= round_display($ref->fFairNetValue).',';
        }
        else
        {
            $str .= '0.0,';
        }
        if ($ref->fRealtimeNetValue)
        {
            $str .= round_display($ref->fRealtimeNetValue).',';     // T+1 net value
        }
        else
        {
            $str .= '0.0,';
        }
        $str .= $ref->stock_ref->strPrice;               // Last trading price
    }
    return $str;
}

function _updateSpiderTables($strList)
{
    SqlCreateVisitorTable(SPIDER_VISITOR_TABLE);
    if ($strDstId = MustGetSpiderParameterId($strList))
    {
        $strIp = UrlGetIp();
        $strSrcId = SqlMustGetIpId($strIp); 
        SqlInsertVisitor(SPIDER_VISITOR_TABLE, $strDstId, $strSrcId);
    }
}

function _main()
{
    SqlConnectDatabase();
    $strOutput = '';
    if ($strList = UrlGetQueryValue('list'))
    {
        _updateSpiderTables($strList);
        $arSymbol = StockGetSymbolArray($strList);
        WeixinStockPrefetchData($arSymbol);
            
        foreach ($arSymbol as $strSymbol)
        {
            $strOutput .= _getSymbolOutput($strSymbol)."\n";
        }
        $strOutput = rtrim($strOutput, "\n");
    }
    echo $strOutput;    
}

    _main();
    
?>
