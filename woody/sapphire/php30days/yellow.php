<?php
require('php/_php30days.php');

function GetTitle($bChinese)
{
	return 'Sapphire 30 Days Photos - Yellow Series';
}

function GetMetaDescription($bChinese)
{
	return 'Sapphire 30 days photos. Yellow series. Taken by professional photographers from Shenzhen Far East International Medical Center.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p>Dress in yellow knit with pink flower. <a href="../30days/large/knit_flower7.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower7.jpg alt="Sapphire Lin dress in yellow knit with pink flower." /></p>

<p>How many pictures are you going to take? <a href="../30days/large/knit_flower6.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower6.jpg alt="Sapphire Lin dress in yellow knit with pink flower, how many pictures are you going to take?" /></p>

<p>Let us count it... <a href="../30days/large/knit_flower5.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower5.jpg alt="Sapphire Lin dress in yellow knit with pink flower, let us count it..." /></p>

<p>I am getting tired. <a href="../30days/large/knit_flower4.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower4.jpg alt="Sapphire Lin dress in yellow knit with pink flower, I am getting tired." /></p>

<p>I am going to cry now. <a href="../30days/large/knit_flower3.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower3.jpg alt="Sapphire Lin dress in yellow knit with pink flower, I am going to cry now." /></p>

<p>Isn't it stupid to put a flower on my left? <a href="../30days/large/knit_flower2.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower2.jpg alt="Sapphire Lin dress in yellow knit with pink flower. Isn't it stupid to put a flower on my left?" /></p>

<p>It is stupid to put a flower on my right too! <a href="../30days/large/knit_flower.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower.jpg alt="Sapphire Lin dress in yellow knit with pink flower. It is stupid to put a flower on my right too!" /></p>

<p>Ok, this is better. <a href="../30days/large/knit_flower8.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower8.jpg alt="Sapphire Lin dress in yellow knit with pink flower. Ok, this is better." /></p>

<p>But it is really to much! <a href="../30days/large/knit_flower9.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit_flower9.jpg alt="Sapphire Lin dress in yellow knit with pink flower. But it is really to much!" /></p>

<p>I really hate the flower, where is my puppy? <a href="../30days/large/knit3.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit3.jpg alt="Sapphire Lin dress in yellow knit. I really hate the flower, where is my puppy?" /></p>

<p>I am confused. <a href="../30days/large/knit2.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit2.jpg alt="Sapphire Lin dress in yellow knit. I am confused" /></p>

<p>I am protesting now! <a href="../30days/large/knit.jpg" target=_blank>Large</a>
<br /><img src=../30days/knit.jpg alt="Sapphire Lin dress in yellow knit. I am protesting now!" /></p>
END;
}

require('/php/ui/_disp.php');
?>
