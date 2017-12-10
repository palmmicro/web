<?php
require_once('debug.php');

// Function to sanitize values received from the form. Prevents SQL injection
function FormatCleanString($str) 
{
	$str = @trim($str);
	if (get_magic_quotes_gpc()) 
	{
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

function FormatGetWeb($strWeb)
{
	$str = $strWeb;
	if (!strchr($strWeb, 'http'))
	{
		$str = 'http://'.$strWeb;
	}
	return DebugGetExternalLink($str, $strWeb); 
}

/*
function FormatGetFirstSentence($str)
{
	$str = html_entity_decode(strip_tags($str));
	$iPos = strpos($str, '.');
	if (!$iPos)
	{
		$iPos = strpos($str, '。');		// Chinese period mark
		if (!$iPos)
		{
			return $str;
		}
	}
	return substr($str, 0, $iPos);
}
*/

?>
