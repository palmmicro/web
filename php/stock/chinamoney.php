<?php

function _chinaMoneyHasFile($ymd_now, $strFileName)
{
	clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        $ar = json_decode($str, true);
        $arHead = $ar['head'];
        if ($arHead['rep_code'] != '200')									return false;		// 200 ok not found
        if ($ymd_now->IsNewFile($strFileName))							return $ar;   		// update on every minute
        $arData = $ar['data'];
        $ymd = new YMDTick(strtotime($arData['lastDate']));								// 2018-04-12 9:15
        if ($ymd->GetNextTradingDayTick() <= $ymd_now->GetTick())		return false;		// need update
//        DebugString('Use current file');
        return $ar;
    }
    return false;
}

function _chinaMoneyNeedData($ymd)
{
    $strDate = $ymd->GetYMD();
    if (SqlGetForexHistory(SqlGetStockId('USCNY'), $strDate) && SqlGetForexHistory(SqlGetStockId('HKCNY'), $strDate))
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
    $ymd_now = new YMDNow();
    if (_chinaMoneyNeedData($ymd_now) == false)		return;
    
	$strFileName = DebugGetChinaMoneyFile();
	$ar = _chinaMoneyHasFile($ymd_now, $strFileName);
    if ($ar == false)
    {
    	if ($str = url_get_contents(ChinaMoneyGetUrl()))
    	{
    		DebugString('Save new file');
    		file_put_contents($strFileName, $str);
    		$ar = json_decode($str, true);
    	}
    	else
    	{
    		DebugString('No data!');
    		return;
    	}
    }
	
    $arData = $ar['data'];
    $strDate = _chinaMoneyNeedData(new YMDTick(strtotime($arData['lastDate'])));		// 2018-04-12 9:15
    if ($strDate == false)		return;

    $arRecord = $ar['records'];
    foreach ($arRecord as $arPair)
    {
    	$strPair = $arPair['vrtEName'];
    	$strPrice = $arPair['price'];
    	DebugString($strPair.' '.$strPrice);
    	if ($strPair == 'USD/CNY')
    	{
    		DebugString('Insert USCNY');
			SqlInsertForexHistory(SqlGetStockId('USCNY'), $strDate, $strPrice);
		}
    	else if ($strPair == 'HKD/CNY')
    	{
    		DebugString('Insert HKCNY');
			SqlInsertForexHistory(SqlGetStockId('HKCNY'), $strDate, $strPrice);
		}
    }
}

?>
