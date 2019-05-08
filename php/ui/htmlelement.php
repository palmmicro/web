<?php

// ****************************** Pravite Functions *******************************************************

function _getHtmlElement($str)
{
    return "$str=\"$str\"";
}

// ****************************** Common Functions *******************************************************

function HtmlElementDisabled()
{
    return _getHtmlElement('disabled');
}

function HtmlElementReadonly()
{
    $str = _getHtmlElement('readonly');
    $str .= ' style="background:#CCCCCC"';
    return $str;
}

function HtmlGetOption($ar)
{
    $str = '';
    foreach ($ar as $strKey => $strVal)
    {
       	$str .= "<OPTION value=$strKey>$strVal</OPTION>";
    }
    return $str;
}

function HtmlGetJsArray($ar)
{
	$str = '';
	foreach ($ar as $strId => $strVal)
	{
		$str .= $strId.':"'.$strVal.'", ';
	}
	return rtrim($str, ', ');
}

?>
