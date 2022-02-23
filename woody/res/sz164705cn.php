<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetUniversalOfficialLink($sym);
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetUniversalSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
