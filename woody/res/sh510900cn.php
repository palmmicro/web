<?php 
require('php/_lofhk.php');

function EchoRelated()
{
	$strGroup = GetLofHkLinks();
	$strHShares = GetHSharesSoftwareLinks();
	$strCompany = GetEFundSoftwareLinks();
	
	echo <<< END
	<p><font color=red>已知问题:</font></p>
	<ol>
    	<li>2018年6月29日星期五, SH510900成立以来首次分红0.05元, 导致当日估值误差4.38%.</li>
    </ol>
	<p> $strGroup
		$strHShares
		$strCompany
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
