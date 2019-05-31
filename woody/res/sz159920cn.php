<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strSpy = GetSpySoftwareLinks();
	$strQqq = GetQqqSoftwareLinks();
	$strCompany = GetChinaAmcSoftwareLinks();
	
	echo <<< END
	<p><font color=red>已知问题:</font></p>
	<ol>
	    <li>2018年6月22日星期五, SZ159920成立以来首次分红0.076元, 导致当日估值误差5.19%.</li>
    </ol>
	<p> $strGroup
		$strSpy
		$strQqq
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
