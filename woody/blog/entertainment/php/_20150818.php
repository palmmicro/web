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

function EchoFundEstTables()
{
	EchoFundEstDemo();

	EchoTableParagraphBegin(array(new TableColumn('估值因素', 140),
								   new TableColumnOfficalEst(),
								   new TableColumnFairEst(),
								   new TableColumnRealtimeEst()
								   ), 'estcompare');
	EchoTableColumn(array('T日美股交易',		'XOP净值',	'XOP净值',	'XOP净值'));
	EchoTableColumn(array('CL期货',			'否',		'否',		'是'));
	EchoTableColumn(array('美元人民币中间价',	'T日',		'T+1日',	'T/T+1日'));
    EchoTableParagraphEnd();
}

?>
