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
        parent::TableColumn('持仓', 105, false, $strPrefix);
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
        parent::TableColumn('比例(%)', $iWidth, 'green', $strPrefix);
	}
}

class TableColumnTradingPercentage extends TableColumnPercentage
{
	function TableColumnTradingPercentage()
	{
        parent::TableColumnPercentage('换手');
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
        parent::TableColumn('盈利', 105, 'red', $strPrefix);
	}
}

class TableColumnQuantity extends TableColumn
{
	function TableColumnQuantity($strPrefix = false)
	{
        parent::TableColumn(STOCK_DISP_QUANTITY, 100, false, $strPrefix);
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

class TableColumnShare extends TableColumn
{
	function TableColumnShare()
	{
        parent::TableColumn('场内份额(万股)', 110);
	}
}

class TableColumnShareDiff extends TableColumn
{
	function TableColumnShareDiff()
	{
        parent::TableColumn(STOCK_OPTION_SHARE_DIFF, 110);
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

class TableColumnStock extends TableColumn
{
	function TableColumnStock($strSymbol, $iWidth = 80)
	{
        parent::TableColumn($strSymbol, $iWidth, 'maroon');
	}
}

function GetTableColumnStock($sym)
{
	$col = new TableColumnStock($sym->GetSymbol());
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
        parent::TableColumn('测试数据', 110);
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

class TableColumnHKD extends TableColumn
{
	function TableColumnHKD($strPrefix = false)
	{
        parent::TableColumn('港币$', 80, false, $strPrefix);
	}
}

class TableColumnUSCNY extends TableColumnStock
{
	function TableColumnUSCNY()
	{
        parent::TableColumnStock('USCNY', 60);
	}
}

class TableColumnHKCNY extends TableColumnStock
{
	function TableColumnHKCNY()
	{
        parent::TableColumnStock('HKCNY', 60);
	}
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
