<?php
require_once('php/_stock.php');
require_once('php/_emptygroup.php');
require_once('../../php/ui/calibrationhistoryparagraph.php');

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		EchoCalibrationHistoryParagraph($ref, $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    }
    $acct->EchoLinks('calibrationhistory');
}    

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(CALIBRATION_HISTORY_DISPLAY);
    $str .= '页面。用于查看、比较和调试估算的股票价格和基金净值之间的校准情况。最新校准时间会直接显示在该基金页面。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(CALIBRATION_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();

require('../../php/ui/_dispcn.php');
?>
