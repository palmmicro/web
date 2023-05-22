<?php
require_once('stockdisp.php');
require_once('stockcomm.php');
require_once('table.php');

class TableColumnAmount extends TableColumn
{
	function TableColumnAmount($strPrefix = false)
	{
        parent::TableColumn('金额', 120, false, $strPrefix);
	}
}

class TableColumnCalibration extends TableColumn
{
	function TableColumnCalibration()
	{
        parent::TableColumn('校准值', 150);
	}
}

class TableColumnChange extends TableColumn
{
	function TableColumnChange($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_CHANGE, 70, false, $strPrefix);
	}
}

class TableColumnError extends TableColumn
{
	function TableColumnError()
	{
        parent::TableColumn('误差', 70);
	}
}

class TableColumnEst extends TableColumn
{
	function TableColumnEst($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_EST, 80, 'magenta', $strPrefix);
	}
}

function GetTableColumnEst()
{
	$col = new TableColumnEst();
	return $col->GetDisplay();
}

class TableColumnOfficalEst extends TableColumnEst
{
	function TableColumnOfficalEst()
	{
        parent::TableColumnEst(STOCK_DISP_OFFICIAL);
	}
}

class TableColumnFairEst extends TableColumnEst
{
	function TableColumnFairEst()
	{
        parent::TableColumnEst(STOCK_DISP_FAIR);
	}
}

class TableColumnRealtimeEst extends TableColumnEst
{
	function TableColumnRealtimeEst()
	{
        parent::TableColumnEst(STOCK_DISP_REALTIME);
	}
}

class TableColumnHolding extends TableColumn
{
	function TableColumnHolding($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_HOLDING, 105, false, $strPrefix);
	}
}

class TableColumnName extends TableColumn
{
	function TableColumnName($strPrefix = false, $iWidth = 270)
	{
        parent::TableColumn('名称', $iWidth, false, $strPrefix);
	}
}

class TableColumnGroupName extends TableColumnName
{
	function TableColumnGroupName()
	{
        parent::TableColumnName('分组', 110);
	}
}

class TableColumnNav extends TableColumn
{
	function TableColumnNav($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_NAV, 90, 'olive', $strPrefix);
	}
}

function GetTableColumnNav()
{
	$col = new TableColumnNav();
	return $col->GetDisplay();
}

class TableColumnPercentage extends TableColumn
{
	function TableColumnPercentage($strPrefix = false, $iWidth = 100)
	{
        parent::TableColumn('比例(%)', $iWidth, false, $strPrefix);
	}
}

class TableColumnPosition extends TableColumn
{
	function TableColumnPosition()
	{
        parent::TableColumn('仓位', 70);
	}
}

class TableColumnPremium extends TableColumn
{
	function TableColumnPremium($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_PREMIUM, 70, 'orange', $strPrefix);
	}
}

function GetTableColumnPremium()
{
	$col = new TableColumnPremium();
	return $col->GetDisplay();
}

class TableColumnPrice extends TableColumn
{
	function TableColumnPrice($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_PRICE, 70, 'blue', $strPrefix);
	}
}

function GetTableColumnPrice()
{
	$col = new TableColumnPrice();
	return $col->GetDisplay();
}

class TableColumnProfit extends TableColumn
{
	function TableColumnProfit($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_PROFIT, 105, 'red', $strPrefix);
	}
}

class TableColumnQuantity extends TableColumn
{
	function TableColumnQuantity($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_QUANTITY, 100, 'indigo', $strPrefix);
	}
}

class TableColumnRatio extends TableColumn
{
	function TableColumnRatio($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_RATIO, 100, false, $strPrefix);
	}
}

class TableColumnShare extends TableColumn
{
	function TableColumnShare()
	{
        parent::TableColumn('份额(万)', 110);
	}
}

class TableColumnStock extends TableColumn
{
	function TableColumnStock($sym, $iWidth = 80)
	{
        parent::TableColumn($sym->GetDisplay(), $iWidth, 'maroon');
	}
}

function GetTableColumnStock($sym)
{
	$col = new TableColumnStock($sym);
	return $col->GetDisplay();
}

class TableColumnSymbol extends TableColumn
{
	function TableColumnSymbol($strPrefix = false, $iWidth = 80)
	{
        parent::TableColumn(STOCK_DISP_SYMBOL, $iWidth, 'maroon', $strPrefix);
	}
}

function GetTableColumnSymbol()
{
	$col = new TableColumnSymbol();
	return $col->GetDisplay();
}

class TableColumnTest extends TableColumn
{
	function TableColumnTest()
	{
        parent::TableColumn('测试', 110);
	}
}

class TableColumnTotalShares extends TableColumn
{
	function TableColumnTotalShares()
	{
        parent::TableColumn('总数量', 90);
	}
}

class TableColumnTurnover extends TableColumn
{
	function TableColumnTurnover($strPrefix = false, $iWidth = 100)
	{
        parent::TableColumn(STOCK_DISP_TURNOVER, $iWidth, 'green', $strPrefix);
	}
}

class TableColumnHKD extends TableColumn
{
	function TableColumnHKD($strPrefix = false)
	{
        parent::TableColumn('港币$', 100, 'blue', $strPrefix);
	}
}

class TableColumnRMB extends TableColumn
{
	function TableColumnRMB($strPrefix = false)
	{
        parent::TableColumn('人民币￥', 100, 'blue', $strPrefix);
	}
}

class TableColumnUSD extends TableColumn
{
	function TableColumnUSD($strPrefix = false)
	{
        parent::TableColumn('美元$', 100, 'blue', $strPrefix);
	}
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
