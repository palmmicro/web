<?php
require('php/_entertainment.php');

function GetMetaDescription($bChinese)
{
	return 'My first PHP application: user and blog comment CRUD (Create/Retrieve/Update/Delete). And other PHP tools software after it.';
}

function _echo20100905($bChinese)
{
	$strAR1688 = GetInternalLink('/ar1688/index.html', 'AR1688');
	$strYahoo = GetInternalLink('/res/translation.html#webhosting', 'Yahoo Web Hosting');
	$strPA6488 = GetInternalLink('/pa6488/index.html', 'PA6488');
	$strCamMan = GetInternalLink('/pa6488/software/camman.html', 'CamMan');
	$strImage = ImgPhpBest($bChinese);
	
	EchoBlogDate($bChinese);
    echo <<<END
<br />The first time I heard about PHP was from an $strAR1688 developer. He told me he had written some PHP script in AR1688 web pages to calculate the total size of the pages in bytes, so the web interface would not fail silently when oversized.
Now I knew he was wrong about the PHP part, maybe he meant Javascript.
<br />Some time later, $strYahoo service which hosted this website prompted me to upgrade from PHP4 to PHP5. For the second time, I realized that PHP was in my life.
<br />Two months ago I got to know an E-Commercial startup, when I asked what development language they were using, again I had PHP in the answers. I was so happy that I was not completely blank on the phrase, at least I had heard it twice before.
<br />With so many knowledge about PHP, when $strPA6488 camera manager software $strCamMan need user management function, I started with PHP on our website at once. Now users can register account to test.
As PA6488 based camera is not available in market yet. Users can test the user management function by posting comments on this blog right now. Only registered user can post comment.
<br />And this is my first PHP application: user and blog comment CRUD (Create/Retrieve/Update/Delete).
$strImage
</p>
END;
}

function EchoAll($bChinese)
{
	_echo20100905($bChinese);
}

require('../../../php/ui/_disp.php');
?>
