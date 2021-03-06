<?php

function _chinaMoneyHasFile($now_ymd, $strFileName)
{
	clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        $ar = json_decode($str, true);
        $arHead = $ar['head'];
        if ($arHead['rep_code'] != '200')									return false;		// 200 ok not found
        if ($now_ymd->IsNewFile($strFileName))							return $ar;   		// update on every minute
        $arData = $ar['data'];
        $ymd = new TickYMD(strtotime($arData['lastDate']));								// 2018-04-12 9:15
        if ($ymd->GetNextTradingDayTick() <= $now_ymd->GetTick())		return false;		// need update
//        DebugString('Use current file');
        return $ar;
    }
    return false;
}

function _chinaMoneyNeedData($ymd, $nav_sql, $strUscnyId, $strHkcnyId)
{
//	if ($ymd->IsWeekend())	return false;
	
    $strDate = $ymd->GetYMD();
    if ($nav_sql->GetRecord($strUscnyId, $strDate) && $nav_sql->GetRecord($strHkcnyId, $strDate))
    {
//    	DebugString('Database entry existed');
    	return false;
    }
    return $strDate;
}

function ChinaMoneyGetUrl()
{
	return 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/data/fx/ccpr.json';
// 	return 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/html/cn/latestRMBParityCn.html';
}

function GetChinaMoney()
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
    $now_ymd = new NowYMD();
	$nav_sql = GetNavHistorySql();
    $strUscnyId = SqlGetStockId('USCNY');
    $strHkcnyId = SqlGetStockId('HKCNY');
    if (_chinaMoneyNeedData($now_ymd, $nav_sql, $strUscnyId, $strHkcnyId) == false)		return;
    
	$strFileName = DebugGetChinaMoneyFile();
	$ar = _chinaMoneyHasFile($now_ymd, $strFileName);
    if ($ar == false)
    {
    	if ($str = url_get_contents(ChinaMoneyGetUrl()))
    	{
    		DebugString($strFileName.': Save new file');
    		file_put_contents($strFileName, $str);
    		$ar = json_decode($str, true);
    	}
    	else	return;
    }
	
    $arData = $ar['data'];
    $strDate = _chinaMoneyNeedData(new TickYMD(strtotime($arData['lastDate'])), $nav_sql, $strUscnyId, $strHkcnyId);		// 2018-04-12 9:15
    if ($strDate == false)		return;

    if (isset($ar['records']) == false)	return;
    foreach ($ar['records'] as $arPair)
    {
    	$strPair = $arPair['vrtEName'];
    	$strPrice = $arPair['price'];
    	DebugString($strPair.' '.$strPrice);
    	if ($strPair == 'USD/CNY')
    	{
    		DebugString('Insert USCNY');
			$nav_sql->InsertDaily($strUscnyId, $strDate, $strPrice);
		}
    	else if ($strPair == 'HKD/CNY')
    	{
    		DebugString('Insert HKCNY');
			$nav_sql->InsertDaily($strHkcnyId, $strDate, $strPrice);
		}
    }
}

?>
