<?php
//require_once('url.php');
require_once('debug.php');
require_once('stock.php');

require_once('sql/sqlvisitor.php');
require_once('sql/sqlspider.php');
require_once('sql/sqlipaddress.php');

function _getNetValueString($fNetValue)
{
    if ($fNetValue)
    {
        return round_display($fNetValue).',';
    }
	return '0.0,';
}

function _getSymbolOutput($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $str = $strSymbol.'_net_value=';
    if ($sym->IsFundA())
    {
        $ref = StockGetFundReference($strSymbol);
        $str .= $ref->strPrice.','.$ref->strDate.',';   		// T-1 net value;
        $str .= _getNetValueString($ref->fOfficialNetValue);	// T net value
        if ($ref->fOfficialNetValue)
        {
            $str .= $ref->strOfficialDate.',';	
        }
        else
        {
            $str .= '0000-00-00,';
        }
        
        $str .= _getNetValueString($ref->fFairNetValue);
        $str .= _getNetValueString($ref->fRealtimeNetValue);	// T+1 net value
        $str .= $ref->stock_ref->strPrice;               		// Last trading price
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
    	$strList = UrlCleanString($strList);
        _updateSpiderTables($strList);
        $arSymbol = StockGetSymbolArray($strList);
        StockPrefetchArrayData($arSymbol);
            
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
