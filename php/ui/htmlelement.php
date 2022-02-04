<?php

function GetHtmlElement($str, $strElement)
{
	return "<$strElement>$str</$strElement>";
}

function _setHtmlElement($str)
{
    return "$str=\"$str\"";
}

function HtmlElementSelected()
{
    return _setHtmlElement('selected');
}

function HtmlElementDisabled()
{
    return _setHtmlElement('disabled');
}

function HtmlElementReadonly()
{
    $str = _setHtmlElement('readonly');
    $str .= ' style="background:#CCCCCC"';
    return $str;
}

function HtmlGetOption($ar, $strCompare = false)
{
    $str = '';
    foreach ($ar as $strKey => $strVal)
    {
    	$strSelected = ($strVal == $strCompare) ? ' '.HtmlElementSelected() : '';
       	$str .= "<OPTION value={$strKey}{$strSelected}>$strVal</OPTION>";
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
