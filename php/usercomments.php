<?php
require_once('blogcomments.php');

function UserComments()
{
	echo '<table><tr><td>';
    BlogComments();
	echo '</td></tr></table>';
}

?>
