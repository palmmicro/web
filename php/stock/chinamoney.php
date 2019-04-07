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

function _chinaMoneyNeedData($ymd, $uscny_sql, $hkcny_sql)
{
	if ($ymd->IsWeekend())	return false;
	
    $strDate = $ymd->GetYMD();
    if ($uscny_sql->Get($strDate) && $hkcny_sql->Get($strDate))
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
    $uscny_sql = new UscnyHistorySql();
    $hkcny_sql = new HkcnyHistorySql();
    if (_chinaMoneyNeedData($now_ymd, $uscny_sql, $hkcny_sql) == false)		return;
    
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
    	else
    	{
    		DebugString('No data!');
    		return;
    	}
    }
	
    $arData = $ar['data'];
    $strDate = _chinaMoneyNeedData(new TickYMD(strtotime($arData['lastDate'])), $uscny_sql, $hkcny_sql);		// 2018-04-12 9:15
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
			$uscny_sql->Insert($strDate, $strPrice);
		}
    	else if ($strPair == 'HKD/CNY')
    	{
    		DebugString('Insert HKCNY');
			$hkcny_sql->Insert($strDate, $strPrice);
		}
    }
}

?>
