<?php 
require('php/_qdiihk.php');

function GetQdiiHkRelated($sym)
{
	$str = GetFontElement('已知问题：').'</p>
	<ol>
	    <li>2018年6月22日星期五，SZ159920成立以来首次分红0.076元，导致当日估值误差5.19%。</li>
    </ol>
	<p>';
	
	$str .= GetHuaXiaOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiHkLinks($sym);
	$str .= GetHuaXiaSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>
