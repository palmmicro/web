<?php
require_once('_entertainment.php');
require_once('/woody/blog/php/_stockdemo.php');

function EchoCalibrationHistoryLink($strSymbol = FUND_DEMO_SYMBOL)
{
	echo GetCalibrationHistoryLink($strSymbol);
}

function EchoFundHistoryLink()
{
	EchoNameLink(FUND_HISTORY_PAGE, FUND_HISTORY_DISPLAY);
}

?>
