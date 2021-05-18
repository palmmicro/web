<?php
require_once('stockdisp.php');
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
        parent::TableColumn('校准值', 100);
	}
}

class TableColumnChange extends TableColumn
{
	function TableColumnChange($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_CHANGE, 70, 'red', $strPrefix);
	}
}

class TableColumnClose extends TableColumn
{
	function TableColumnClose($strPrefix = false)
	{
        parent::TableColumn('收盘价', 80, 'purple', $strPrefix);
	}
}

class TableColumnError extends TableColumn
{
	function TableColumnError()
	{
        parent::TableColumn('误差', 70);
	}
}

function GetTableColumnError()
{
	$col = new TableColumnError();
	return $col->GetDisplay();
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

class TableColumnHolding extends TableColumn
{
	function TableColumnHolding($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_HOLDING, 120, false, $strPrefix);
	}
}

class TableColumnName extends TableColumn
{
	function TableColumnName()
	{
        parent::TableColumn('名称', 270);
	}
}

class TableColumnNetValue extends TableColumn
{
	function TableColumnNetValue($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_NETVALUE, 90, 'olive', $strPrefix);
	}
}

class TableColumnPosition extends TableColumn
{
	function TableColumnPosition()
	{
        parent::TableColumn('仓位', 90);
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
        parent::TableColumn(STOCK_DISP_PROFIT, 120, false, $strPrefix);
	}
}

class TableColumnRatio extends TableColumn
{
	function TableColumnRatio($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_RATIO, 80, false, $strPrefix);
	}
}

class TableColumnAhRatio extends TableColumnRatio
{
	function TableColumnAhRatio()
	{
        parent::TableColumnRatio('AH');
	}
}

class TableColumnHaRatio extends TableColumnRatio
{
	function TableColumnHaRatio()
	{
        parent::TableColumnRatio('HA');
	}
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
	function TableColumnSymbol($strPrefix = false, $iWidth = 80)
	{
        parent::TableColumn('代码', $iWidth, 'maroon', $strPrefix);
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
        parent::TableColumn('测试数据');
	}
}

class TableColumnTotalShares extends TableColumn
{
	function TableColumnTotalShares()
	{
        parent::TableColumn('总数量', 90);
	}
}

class TableColumnUSD extends TableColumn
{
	function TableColumnUSD($strPrefix = false)
	{
        parent::TableColumn('美元$', 80, false, $strPrefix);
	}
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

class TableColumnMyStock extends TableColumn
{
	function TableColumnMyStock($strSymbol, $iWidth = 80)
	{
        parent::TableColumn(GetMyStockLink($strSymbol), $iWidth);
	}
}

class TableColumnStockGroup extends TableColumn
{
	function TableColumnStockGroup($iWidth = 110)
	{
        parent::TableColumn(GetMyStockGroupLink(), $iWidth);
	}
}

class TableColumnUSCNY extends TableColumnMyStock
{
	function TableColumnUSCNY()
	{
        parent::TableColumnMyStock('USCNY', 60);
	}
}

class TableColumnHKCNY extends TableColumnMyStock
{
	function TableColumnHKCNY()
	{
        parent::TableColumnMyStock('HKCNY', 60);
	}
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
