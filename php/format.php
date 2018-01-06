<?php

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

?>
