<?php
require_once('plaintext.php');

define('TABLE_COMMON_DISPLAY', 10);

function IsTableCommonDisplay($iStart, $iNum)
{
	return (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))	 ? true : false;
}

function GetTableColumn($iWidth, $strDisplay)
{
	$strWidth = strval($iWidth);
	return "<td class=c1 width=$strWidth align=center>$strDisplay</td>";
}

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
class TableColumn
{
	var $strText;
	var $iWidth;
	
	function TableColumn($strText, $iWidth = 80, $strColor = false, $strPrefix = false)
	{
		$this->iWidth = $iWidth;
		$this->strText = $strColor ? "<font color=$strColor>$strText</font>" : $strText;
        if ($strPrefix)
        {
        	$this->strText = $strPrefix.$this->strText; 
        }
	}
	
	function GetDisplay()
	{
		return $this->strText;
	}
	
	function GetWidth()
	{
		return $this->iWidth;
	}
	
	function GetEchoString()
	{
		return GetTableColumn($this->iWidth, $this->strText);
	}
}

class TableColumnDate extends TableColumn
{
	function TableColumnDate($strPrefix = false, $bChinese = true)
	{
        parent::TableColumn(($bChinese ? '日期' : 'Date'), 100, false, $strPrefix);
	}
}

function GetTableColumnDate()
{
	$col = new TableColumnDate();
	return $col->GetDisplay();
}

class TableColumnIP extends TableColumn
{
	function TableColumnIP()
	{
        parent::TableColumn('IP', 140);
	}
}

class TableColumnTime extends TableColumn
{
	function TableColumnTime($bChinese = true)
	{
        parent::TableColumn(($bChinese ? '时间' : 'Time'), 50);
	}
}

function GetTableColumnTime()
{
	$col = new TableColumnTime();
	return $col->GetDisplay();
}

// ****************************** Common Table Functions *******************************************************

function EchoParagraph($str)
{
    echo <<<END
    <p>$str
    </p>
END;
}

function EchoTableParagraphBegin($ar, $strId, $str = '')
{
    $strColumn = '';
	$iTotal = 0;
	foreach ($ar as $col)
	{
		$iTotal += $col->GetWidth();
		$strColumn .= $col->GetEchoString();
	}
    $strWidth = strval($iTotal);
	if ($iTotal > 640)	trigger_error('Table too wide: '.$strWidth);

    echo <<<END
    	<p>$str
        <TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="$strId">
        <tr>
            $strColumn
        </tr>
END;
}

function EchoTableColumn($ar, $strColor = false)
{
    $strBackGround = $strColor ? 'style="background-color:'.$strColor.'"' : '';
    $strColumn = '';
	foreach ($ar as $str)
	{
		$strColumn .= "<td $strBackGround class=c1>$str</td>";
	}

    echo <<<END
        <tr>
            $strColumn
        </tr>
END;
}

function EchoTableParagraphEnd($str = '')
{
    echo <<<END
    </TABLE>
    $str</p>
END;
}

?>
