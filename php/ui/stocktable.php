<?php
require_once('stockdisp.php');
require_once('stockcomm.php');
require_once('table.php');

class TableColumnAmount extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct('金额', 120, false, $strPrefix);
	}
}

class TableColumnCalibration extends TableColumn
{
	public function __construct()
	{
        parent::__construct('校准值', 140);
	}
}

class TableColumnChange extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_CHANGE, 70, false, $strPrefix);
	}
}

class TableColumnConvert extends TableColumn
{
	public function __construct()
	{
        parent::__construct(STOCK_DISP_CONVERT, 80, 'navy');
	}
}

function GetTableColumnConvert()
{
	$col = new TableColumnConvert();
	return $col->GetDisplay();
}

class TableColumnError extends TableColumn
{
	public function __construct()
	{
        parent::__construct('误差', 70);
	}
}

class TableColumnEst extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_EST, 80, 'magenta', $strPrefix);
	}
}

function GetTableColumnEst()
{
	$col = new TableColumnEst();
	return $col->GetDisplay();
}

class TableColumnOfficalEst extends TableColumnEst
{
	public function __construct()
	{
        parent::__construct(STOCK_DISP_OFFICIAL);
	}
}

class TableColumnFairEst extends TableColumnEst
{
	public function __construct()
	{
        parent::__construct(STOCK_DISP_FAIR);
	}
}

class TableColumnRealtimeEst extends TableColumnEst
{
	public function __construct()
	{
        parent::__construct(STOCK_DISP_REALTIME);
	}
}

class TableColumnHolding extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_HOLDING, 105, false, $strPrefix);
	}
}

class TableColumnName extends TableColumn
{
	public function __construct($strPrefix = false, $iWidth = 150)
	{
        parent::__construct('名称', $iWidth, false, $strPrefix);
	}
}

class TableColumnGroupName extends TableColumnName
{
	public function __construct()
	{
        parent::__construct('分组', 110);
	}
}

class TableColumnNav extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_NAV, 90, 'olive', $strPrefix);
	}
}

function GetTableColumnNav()
{
	$col = new TableColumnNav();
	return $col->GetDisplay();
}

class TableColumnPercentage extends TableColumn
{
	public function __construct($strPrefix = false, $iWidth = 100)
	{
        parent::__construct('比例(%)', $iWidth, false, $strPrefix);
	}
}

class TableColumnPosition extends TableColumn
{
	public function __construct()
	{
        parent::__construct(STOCK_DISP_POSITION, 70);
	}
}

class TableColumnPremium extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_PREMIUM, 70, 'orange', $strPrefix);
	}
}

function GetTableColumnPremium()
{
	$col = new TableColumnPremium();
	return $col->GetDisplay();
}

class TableColumnPrice extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_PRICE, 70, 'blue', $strPrefix);
	}
}

function GetTableColumnPrice()
{
	$col = new TableColumnPrice();
	return $col->GetDisplay();
}

class TableColumnProfit extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_PROFIT, 105, 'red', $strPrefix);
	}
}

class TableColumnQuantity extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_QUANTITY, 100, 'indigo', $strPrefix);
	}
}

class TableColumnRatio extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct(STOCK_DISP_RATIO, 100, false, $strPrefix);
	}
}

class TableColumnShare extends TableColumn
{
	public function __construct()
	{
        parent::__construct('份额(万)', 110);
	}
}

class TableColumnStock extends TableColumn
{
	public function __construct($sym, $iWidth = 80)
	{
        parent::__construct($sym->GetDisplay(), $iWidth, 'maroon');
	}
}

function GetTableColumnStock($sym)
{
	$col = new TableColumnStock($sym);
	return $col->GetDisplay();
}

class TableColumnSymbol extends TableColumn
{
	public function __construct($strPrefix = false, $iWidth = 80)
	{
        parent::__construct(STOCK_DISP_SYMBOL, $iWidth, 'maroon', $strPrefix);
	}
}

function GetTableColumnSymbol()
{
	$col = new TableColumnSymbol();
	return $col->GetDisplay();
}

class TableColumnTest extends TableColumn
{
	public function __construct()
	{
        parent::__construct('测试', 110);
	}
}

class TableColumnTotalShares extends TableColumn
{
	public function __construct()
	{
        parent::__construct('总数量', 90);
	}
}

class TableColumnTurnover extends TableColumn
{
	public function __construct($strPrefix = false, $iWidth = 100)
	{
        parent::__construct(STOCK_DISP_TURNOVER, $iWidth, 'green', $strPrefix);
	}
}

class TableColumnHKD extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct('港币$', 100, 'blue', $strPrefix);
	}
}

class TableColumnRMB extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct('人民币￥', 100, 'blue', $strPrefix);
	}
}

class TableColumnUSD extends TableColumn
{
	public function __construct($strPrefix = false)
	{
        parent::__construct('美元$', 100, 'blue', $strPrefix);
	}
}

function GetTransactionTableColumn()
{
    return array(GetTableColumnDate(), GetTableColumnSymbol(), '数量', GetTableColumnPrice(), '交易费用', '备注', '操作');
}

?>
