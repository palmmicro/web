<?php
require_once('account.php');
require_once('stock.php');
//require_once('stocktrans.php');
//require_once('stock/csindex.php');		// 中证指数有限公司
require_once('stock/sinastock.php');

//require_once('sql/sqlkeystring.php');

define('DEBUG_UTF8_BOM', "\xef\xbb\xbf");

// http://www.todayir.com/en/index.php HSFML25

function _debug_dividend($strSymbol)
{
	if ($arMatch = SinaGetStockDividendA($strSymbol))
	{
		$iVal = count($arMatch);
	
		DebugVal($iVal);
		for ($j = 0; $j < $iVal; $j ++)
		{
			DebugString($arMatch[$j][0]);
			for ($i = 1; $i < 9; $i ++) DebugString($arMatch[$j][$i]);
		}
	}
}

function TestCmdLine()
{
	DebugString('cmd line test '.UrlGetQueryString());
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$strSrc = UrlGetQueryDisplay('src', 'yahoo');
    	$ref = new MyStockReference($strSymbol);
    	DebugString('Stock ID '.$ref->GetStockId());
    	$fStart = microtime(true);
    	switch ($strSrc)
    	{
    	case 'yahoo':		
    		$str = YahooGetWebData($ref);
    		break;
    	
    	case 'sina':
    		_debug_dividend($strSymbol);
			break;
    	}
    	if (empty($str))	$str = '(Not found)';
    	DebugString($strSymbol.':'.$str.DebugGetStopWatchDisplay($fStart));
    }
}

/*
function TestModifyTransactions($strGroupId, $strSymbol, $strNewSymbol, $iRatio)
{
	$sql = new StockGroupItemSql($strGroupId);
	$strGroupItemId = $sql->GetId(SqlGetStockId($strSymbol));
	$strNewGroupItemId = $sql->GetId(SqlGetStockId($strNewSymbol));
	$fUshkd = SqlGetUshkd();
	DebugVal($fUshkd);
    if ($result = $sql->GetAllStockTransaction()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	if ($strGroupItemId == $record['groupitem_id'])
        	{
//        		DebugPrint($record);
//        		$sql->trans_sql->Update($record['id'], $strNewGroupItemId, $record['quantity'], $record['price'], $record['fees'], $record['remark'].$strSymbol);
				$strQuantity = strval($iRatio * intval($record['quantity']));
				$strPrice = strval(floatval($record['price']) * $fUshkd / $iRatio);
				$strFees = strval(floatval($record['fees']) * $fUshkd);
        		$sql->trans_sql->Update($record['id'], $strNewGroupItemId, $strQuantity, $strPrice, $strFees, $record['remark'].$strSymbol);
        	}
        }
        @mysql_free_result($result);
    }
   	UpdateStockGroupItem($strGroupId, $strGroupItemId);
}
*/

function TestDeleteOldSymbol($strSymbol)
{
	$sql = GetStockSql();
	if ($strStockId = $sql->GetId($strSymbol))
	{
		$sym = new StockSymbol($strSymbol);
		unlinkEmptyFile(DebugGetSinaFileName($sym->GetSinaSymbol()));
		
		$his_sql = GetStockHistorySql();
		$his_sql->DeleteAll($strStockId);
		
		$sql->DeleteById($strStockId);
		DebugString($strSymbol.' deleted');
	}
}

function TestDeleteOldSymbols()
{
	foreach (func_get_args() as $strSymbol)	TestDeleteOldSymbol($strSymbol);
}

function DebugLogFile()
{
    $strFileName = UrlGetRootDir().'logs/scripts.log';
    clearstatcache();
	if (file_exists($strFileName))
	{
		DebugString(file_get_contents($strFileName));
		unlink($strFileName);
	}
}

function DebugClearPath($strSection)
{
    $strPath = DebugGetPath($strSection);
    $hDir = opendir($strPath);
    while ($strFileName = readdir($hDir))
    {
    	if ($strFileName != '.' && $strFileName != '..')
    	{
    		$strPathName = $strPath.'/'.$strFileName;
    		if (!is_dir($strPathName)) 
    		{
    			unlink($strPathName);
    		}
    		else 
    		{
    			DebugString('Unexpected subdir: '.$strPathName); 
    		}
    	}
    }
	closedir($hDir);
}

function SqlDeleteStockGroup($strGroupName)
{
	$group_sql = new StockGroupSql();
	$iCount = $group_sql->CountByString($strGroupName); 
	DebugVal($iCount, 'Total stock group named '.$strGroupName);
	if ($iCount > 0)	$group_sql->DeleteByString($strGroupName);
}

function SqlClearStockGroupItem()
{
	$item_sql = new StockGroupItemSql();
	DebugVal($item_sql->Count(), 'Total stock group items');
	
	$sql = GetStockSql();
	$group_sql = new StockGroupSql();
	$iCount = 0;
	$ar = array();
   	if ($result = $item_sql->GetAll())
   	{
   		while ($record = mysql_fetch_assoc($result)) 
   		{
   			$strGroupId = $record['stockgroup_id'];
   			if ($group_sql->GetRecordById($strGroupId) == false)
   			{
   				$iCount ++;
   				$ar[] = $record['id'];
   				$strDebug = 'Missing group id: '.$strGroupId;
   				if ($strSymbol = $sql->GetStockSymbol($record['stock_id']))	$strDebug .= ' with '.$strSymbol.' '.$sql->GetStockName($strSymbol);
   				DebugString($strDebug);
    		}
    	}
   		@mysql_free_result($result);
    }
    
    if ($iCount > 0)
    {
    	DebugVal($iCount, 'Total error');
    	foreach ($ar as $strId)		$item_sql->DeleteById($strId);
    }
}

function SqlCleanStockTransaction()
{
	$trans_sql = new StockTransactionSql();
	DebugVal($trans_sql->CountData(), 'Total stock transactions');
	
	$item_sql = new StockGroupItemSql();
	$iCount = 0;
	$ar = array();
   	if ($result = $trans_sql->GetData())
   	{
   		while ($record = mysql_fetch_assoc($result)) 
   		{
   			$strItemId = $record['groupitem_id'];
   			if ($item_sql->GetRecordById($strItemId) == false)
   			{
   				$iCount ++;
   				$ar[] = $record['id'];
   				DebugString('Missing stock group item id: '.$strItemId);
    		}
    	}
   		@mysql_free_result($result);
    }
    
    if ($iCount > 0)
    {
    	DebugVal($iCount, 'Total error');
    	foreach ($ar as $strId)		$trans_sql->DeleteById($strId);
    }
}

	$acct = new Account();
	if ($acct->AllowCurl() == false)		die('Crawler not allowed on this page');

    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

	file_put_contents(DebugGetFile(), DEBUG_UTF8_BOM.'Start debug:'.PHP_EOL);
	DebugString($_SERVER['DOCUMENT_ROOT']);
	DebugString(phpversion());
	DebugLogFile();
	echo strval(rand()).' Hello, world!<br />';
	
	TestCmdLine();
	DebugClearPath('csv');
	DebugClearPath('image');

	TestDeleteOldSymbols('ACH', 'CEO', 'CHA', 'CHU', 'CHL', 'GSH', 'HNP', 'LFC', 'PTR', 'SHI', 'SINA', 'SMI', 'SNP');
	
    $his_sql = GetStockHistorySql();
    $iCount = $his_sql->DeleteClose();
	if ($iCount > 0)	DebugVal($iCount, 'Zero close data');

//	SqlDeleteStockGroup('ZNH');
//	SqlClearStockGroupItem();	
//	SqlCleanStockTransaction();
	
//    $iCount = $his_sql->DeleteInvalidDate();		// this can be very slow!
//	if ($iCount > 0)	DebugVal($iCount, 'Invalid or older date'); 
	
//	CsindexGetData();

//	TestModifyTransactions('1376', 'UWT', 'USO');
//	TestModifyTransactions('1831', 'CHU', '00762', 10);
//	TestModifyTransactions('160', 'SNP', '00386', 100);

//	phpinfo();
?>
