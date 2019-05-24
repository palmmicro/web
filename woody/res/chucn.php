<?php 
require('php/_adr.php');

function EchoRelated()
{
	$strGroup = GetAdrLinks();
	$str = GetExternalLink('http://stock.hexun.com/2017-08-22/190530561.html', '中国联通A股和港股的关系');
	
	echo <<< END
	<p> $str
	<br />$strGroup
	</p>
END;
}

require('/php/ui/_dispcn.php');
?>
