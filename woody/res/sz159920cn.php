<?php 
require('php/_lofhk.php');

function GetLofHkRelated($sym)
{
	$str = '<font color=red>已知问题:</font></p>
	<ol>
	    <li>2018年6月22日星期五, SZ159920成立以来首次分红0.076元, 导致当日估值误差5.19%.</li>
    </ol>
	<p>';
	$str .= GetLofHkLinks($sym);
	$str .= GetSpySoftwareLinks();
	$str .= GetQqqSoftwareLinks();
	$str .= GetChinaAmcSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
