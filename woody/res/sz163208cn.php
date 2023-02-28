<?php 
require('php/_qdii.php');

// IXC*19.43;XLE*19.1;VDE*18.76;IYE*18.42;XOP*17.9
function GetQdiiRelated($strDigitA)
{
	$str = GetBreakElement().GetSpdrOfficialLink('XLE').' '.GetSpindicesOfficialLink('GSPE');
	$str .= GetNuoAnSoftwareLinks($strDigitA);
	return $str;
}

require('../../php/ui/_dispcn.php');
?>
