<?php 
require('php/_blogphoto.php');

function GetMetaDescription($bChinese)
{
	return 'Pictures from Woody 2012 blog. Including standard AR168R RoIP module photo by an user from Denmark etc.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Nov 11 <a href="ar1688/20121111.php">Logic Puzzle: Find the Differences ...</a>
<br /><img src=photo/20121111.jpg alt="Standard AR168R RoIP module photo by an user from Denmark." /></p>

<p>Aug 11 Eroda Z1 <a href="entertainment/20120811.php">GPS</a>
<br /><img src=photo/20120811.jpg alt="Eroda Z1 GPS and package." /></p>
END;
}

require('/php/ui/_disp.php');
?>
