<?php
require_once('/php/class/PHPExcel/IOFactory.php');

function _readXlsFile($strPathName, $sql)
{
	date_default_timezone_set(STOCK_TIME_ZONE_US);
	try 
	{	// 读取excel文件
		$inputFileType = PHPExcel_IOFactory::identify($strPathName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($strPathName);
	} 
	catch(Exception $e) 
	{
		die('加载文件发生错误: "'.pathinfo($strPathName, PATHINFO_BASENAME).'": '.$e->getMessage());
	}

	// 确定要读取的sheet，什么是sheet，看excel的右下角
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();

	$oldest_ymd = new OldestYMD();
	
	// 获取一行的数据
	$iCount = 0;
	for ($row = 1; $row <= $highestRow; $row++)
	{
		// Read a row of data into an array
		$rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, false);
		//这里得到的rowData都是一行的数据，得到数据后自行处理，我们这里只打出来看看效果
//		var_dump($rowData);
		$ar = $rowData[0];
		if ($iTick = strtotime($ar[0]))
		{
    		$ymd = new TickYMD($iTick);
    		$strDate = $ymd->GetYMD();
   			if ($oldest_ymd->IsInvalid($strDate) == false)
   			{
//   				DebugString($strDate.' '.$ar[1]);
  				if ($sql->Write($strDate, $ar[1]))
  				{
  					$iCount ++;
  				}
   			}
		}
	}
	return '更新'.strval($iCount).'条数据';
}

// https://us.spdrs.com/site-content/xls/XOP_HistoricalNav.xls
function GetSpdrNavXlsStr($strSymbol)
{
	$stock_sql = new StockSql();
	$record = $stock_sql->Get($strSymbol);
   	if (stripos($record['name'], 'spdr') !== false)
	{
		$strFileName = $strSymbol.'_HistoricalNav.xls';
		$strUrl = 'https://us.spdrs.com/site-content/xls/'.$strFileName;
		$str = url_get_contents($strUrl);
//		DebugString($str);
		$strPathName = DebugGetPathName($strFileName);
		file_put_contents($strPathName, $str);
		
        $sql = new NetValueHistorySql($record['id']);
		return _readXlsFile($strPathName, $sql);
	}
	return $strSymbol.'不是SPDR的ETF';
}

?>
