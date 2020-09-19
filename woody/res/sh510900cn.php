<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = '<font color=red>已知问题:</font></p>
	<ol>
    	<li>2018年6月29日星期五, SH510900成立以来首次分红0.05元, 导致当日估值误差4.38%.</li>
    </ol>
	<p>';

	$str = GetEFundOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetHSharesSoftwareLinks();
	$str .= GetEFundSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
