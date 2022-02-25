<?php
require_once('plaintext.php');

define('TABLE_COMMON_DISPLAY', 10);

function IsTableCommonDisplay($iStart, $iNum)
{
	return (($iStart == 0) && ($iNum == TABLE_COMMON_DISPLAY))	 ? true : false;
}

function GetTableRow($str)
{
	return GetHtmlElement($str, 'tr');
}

function GetTableColumnHead($iWidth, $strDisplay)
{
	$strWidth = strval($iWidth);
//	return "<td class=c1 width=$strWidth align=center>$strDisplay</td>";
	return GetHtmlElement($strDisplay, 'th', array('class' => 'c1', 'width' => $strWidth, 'align' => 'left'));
}

// aqua, black, blue, fuchsia, gray, green, lime, maroon, navy, olive, purple, red, silver, teal, white, yellow
class TableColumn
{
	var $strText;
	var $iWidth;
	
	function TableColumn($strText = '', $iWidth = 80, $strColor = false, $strPrefix = false)
	{
		$this->iWidth = $iWidth;
		$this->strText = $strColor ? GetFontElement($strText, $strColor) : $strText;
        if ($strPrefix)	$this->strText = $strPrefix.$this->strText; 
	}
	
	function GetText()
	{
		return $this->strText;
	}
	
	function GetWidth()
	{
		return $this->iWidth;
	}
	
	function GetDisplay()
	{
		return GetBoldElement($this->strText);
	}
	
	function GetHead()
	{
		return GetTableColumnHead($this->iWidth, $this->strText);
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

function EchoTableParagraphBegin($ar, $strId, $str = '')
{
    $strColumn = '';
	$iTotal = 0;
	foreach ($ar as $col)
	{
		$iTotal += $col->GetWidth();
		$strColumn .= $col->GetHead();
	}
    $strWidth = strval($iTotal);
	if ($iTotal > 640)	trigger_error('Table too wide: '.$strWidth);

	$strColumn = GetTableRow($strColumn);
	$strColumn = GetHtmlElement($strColumn, 'thead');
    echo <<<END
    
    <p>$str
    	<TABLE borderColor=#cccccc cellSpacing=0 width=$strWidth border=1 class="text" id="$strId">
        	$strColumn
        	<tbody>
END;
}

function SelectColumnItem($strDisplay, $strLink, $strId, &$arId)
{
	if (in_array($strId, $arId))
    {
    	return $strDisplay;
    }
    $arId[] = $strId;
    return $strLink;
}

function EchoTableColumn($ar, $strColor = false, $strFirstHint = false)
{
	$arAttribute = array('class' => 'c1');
	if ($strColor)	$arAttribute['style'] = '"background-color:'.$strColor.'"';
	
    $strColumn = '';
	foreach ($ar as $str)
	{
		if ($strFirstHint)	$arAttribute['title'] = GetDoubleQuotes($strFirstHint);
		$strColumn .= GetHtmlElement($str, 'td', $arAttribute);
		if ($strFirstHint)
		{
			$strFirstHint = false;
			unset($arAttribute['title']);
		}
	}

	$strColumn = GetTableRow($strColumn);
    echo <<<END
        
    		$strColumn
END;
}

function EchoTableParagraphEnd($str = '')
{
    echo <<<END
    	
    		</tbody>
    	</TABLE>
    	$str
    </p>
END;
}

?>
