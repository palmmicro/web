<?php
require_once('stockdisp.php');
require_once('table.php');

class TableColumnChange extends TableColumn
{
	function TableColumnChange()
	{
        parent::TableColumn(STOCK_DISP_CHANGE, 70, 'red');
        $this->AddUnit();
	}
}

function GetTableColumnChange()
{
	$col = new TableColumnChange();
	return $col->GetDisplay();
}

class TableColumnClose extends TableColumn
{
	function TableColumnClose()
	{
        parent::TableColumn('收盘价', 70, 'purple');
	}
}

function GetTableColumnClose()
{
	$col = new TableColumnClose();
	return $col->GetDisplay();
}

class TableColumnDate extends TableColumn
{
	function TableColumnDate()
	{
        parent::TableColumn('日期', 100);
	}
}

function GetTableColumnDate()
{
	$col = new TableColumnDate();
	return $col->GetDisplay();
}

class TableColumnError extends TableColumn
{
	function TableColumnError()
	{
        parent::TableColumn('误差', 60);
        $this->AddUnit();
	}
}

function GetTableColumnError()
{
	$col = new TableColumnError();
	return $col->GetDisplay();
}

class TableColumnEst extends TableColumn
{
	function TableColumnEst()
	{
        parent::TableColumn(STOCK_DISP_EST, 80, 'magenta');
	}
}

function GetTableColumnEst()
{
	$col = new TableColumnEst();
	return $col->GetDisplay();
}

class TableColumnNetValue extends TableColumn
{
	function TableColumnNetValue()
	{
        parent::TableColumn(STOCK_DISP_NETVALUE, 80, 'olive');
	}
}

function GetTableColumnNetValue()
{
	$col = new TableColumnNetValue();
	return $col->GetDisplay();
}

class TableColumnPremium extends TableColumn
{
	function TableColumnPremium()
	{
        parent::TableColumn(STOCK_DISP_PREMIUM, 80, 'orange');
        $this->AddUnit();
	}
}

function GetTableColumnPremium()
{
	$col = new TableColumnPremium();
	return $col->GetDisplay();
}

class TableColumnPrice extends TableColumn
{
	function TableColumnPrice()
	{
        parent::TableColumn(STOCK_DISP_PRICE, 70, 'blue');
	}
}

function GetTableColumnPrice()
{
	$col = new TableColumnPrice();
	return $col->GetDisplay();
}

class TableColumnSma extends TableColumn
{
	function TableColumnSma()
	{
        parent::TableColumn('均线', 90, 'indigo');
	}
}

function GetTableColumnSma()
{
	$col = new TableColumnSma();
	return $col->GetDisplay();
}

class TableColumnSymbol extends TableColumn
{
	function TableColumnSymbol()
	{
        parent::TableColumn('代码', 80, 'maroon');
	}
}

function GetTableColumnSymbol()
{
	$col = new TableColumnSymbol();
	return $col->GetDisplay();
}

class TableColumnTime extends TableColumn
{
	function TableColumnTime()
	{
        parent::TableColumn('时间', 50);
	}
}

function GetTableColumnTime()
{
	$col = new TableColumnTime();
	return $col->GetDisplay();
}

function GetReferenceTableColumn()			
{
    return array(GetTableColumnSymbol(), GetTableColumnPrice(), GetTableColumnChange(), GetTableColumnDate(), GetTableColumnTime(), '名称');
}

function GetTableColumnOfficalEst()
{
	return STOCK_DISP_OFFICIAL.GetTableColumnEst();
}

function GetTableColumnOfficalPremium()
{
	return STOCK_DISP_OFFICIAL.GetTableColumnPremium();
}

function GetTableColumnFairPremium()
{
	return STOCK_DISP_FAIR.GetTableColumnPremium();
}

function GetTableColumnRealtimeEst()
{
	return STOCK_DISP_REALTIME.GetTableColumnEst();
}

function GetTableColumnRealtimePremium()
{
	return STOCK_DISP_REALTIME.GetTableColumnPremium();
}

function GetFundHistoryTableColumn($est_ref)
{
    if ($est_ref)
    {
		$strSymbol = RefGetMyStockLink($est_ref);
        $strChange = GetTableColumnChange();
    }
    else
    {
        $strSymbol = '';
        $strChange = '';
    }
    
	return array(GetTableColumnDate(), GetTableColumnClose(), GetTableColumnNetValue(), GetTableColumnPremium(), $strSymbol, $strChange, GetTableColumnOfficalEst(), GetTableColumnTime(), GetTableColumnError());
}

function GetAhCompareTableColumn()
{
    return array('A股'.GetTableColumnSymbol(), 'AH比价', 'HA比价');
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
