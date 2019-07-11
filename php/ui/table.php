<?php
require_once('plaintext.php');

define('TABLE_COMMON_DISPLAY', 10);

function IsTableCommonDisplay($iStart, $iNum)
{
	return (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))	 ? true : false;
}

function GetTableColumnColor($strColor)
{
    return $strColor ? 'style="background-color:'.$strColor.'"' : '';
}

function GetTableColumnDisplay($strDisplay, $strColor = false)
{
    $strBackGround = GetTableColumnColor($strColor);
	return "<td $strBackGround class=c1>$strDisplay</td>";
}

function GetTableColumn($iWidth, $strDisplay)
{
	$strWidth = strval($iWidth);
	return "<td class=c1 width=$strWidth align=center>$strDisplay</td>";
}

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
class TableColumn
{
	var $strDisplay;
	var $iWidth;
	
	function TableColumn($strText, $iWidth = 80, $strColor = false)
	{
		$this->iWidth = $iWidth;
		$this->strDisplay = $strColor ? "<font color=$strColor>$strText</font>" : $strText;
	}
	
	function AddUnit($strUnit = '%')
	{
		$this->strDisplay .= '('.$strUnit.')'; 
	}
	
	function AddPrefix($strPrefix)
	{
		$this->strDisplay = $strPrefix.$this->strDisplay; 
	}
	
	function GetDisplay()
	{
		return $this->strDisplay;
	}
	
	function GetWidth()
	{
		return $this->iWidth;
	}
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
		$iWidth = $col->GetWidth();
		$iTotal += $iWidth;
		
		$strWidth = strval($iWidth);
		$strDisplay = $col->GetDisplay();
		$strColumn .= "<td class=c1 width=$strWidth align=center>$strDisplay</td>";
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

function EchoTableParagraphEnd($str = '')
{
    echo <<<END
    </TABLE>
    $str</p>
END;
}

?>
