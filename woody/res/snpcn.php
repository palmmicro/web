<?php 
require('php/_adr.php');

function EchoRelated()
{
	$strGroup = GetAdrLinks();
	$strOil = GetOilSoftwareLinks();
	
	echo <<< END
	<p><font color=red>已知问题:</font></p>
	<ol>
		<li>2018年9月3日星期一, 00386分红除权, 导致AH和ADRH对比不准. SNP的分红除权在9月5日, 而SH600028的分红除权在9月12日.</li>
	</ol>
	<p> $strGroup
		$strOil
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
