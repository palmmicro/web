<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/calibrationparagraph.php');

function EchoAll()
{
	global $group;
	
	$bAdmin = $group->IsAdmin();
    if ($ref = $group->EchoStockGroup())
    {
    	if ($ref->HasData())
    	{
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		EchoCalibrationParagraph($ref, $iStart, $iNum, $bAdmin);
    	}
    }
    $group->EchoLinks('calibration');
}    

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().CALIBRATION_HISTORY_DISPLAY;
    $str .= '页面. 用于查看, 比较和调试估算的股票价格或者基金净值之间的校准情况. 最新的校准时间一般会直接显示在该股票或者基金的页面.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().CALIBRATION_HISTORY_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage();

?>

