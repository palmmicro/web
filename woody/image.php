<?php
require('php/_woody.php');

function GetTitle($bChinese)
{
	return "Woody's Image";
}

function GetMetaDescription($bChinese)
{
	return "List and classification of all Woody's image, including my daughter Sapphire and blog pictures, with my precious bike photo taken in early spring 2007.";
}

function EchoAll($bChinese)
{
	$strImage = ImgWoodyBike($bChinese);
	$strMenu = GetWoodyMenuParagraph($bChinese);
	
    echo <<<END
<p>Album of myself: <a href="myphoto/photo2015.php">2015</a> <a href="myphoto/photo2014.php">2014</a> <a href="myphoto/photo2012.php">2012</a> <a href="myphoto/photo2011.php">2011</a>
<a href="myphoto/photo2010.php">2010</a> <a href="myphoto/photo2009.php">2009</a> <a href="myphoto/photo2008.php">2008</a> <a href="myphoto/photo2007.php">2007</a> <a href="myphoto/photo2006.php">2006</a>
</p>

<p>Album of <a href="blog/entertainment/20141204.php">Sapphire</a>:
<a href="sapphire/photo2018.php">2018</a> <a href="sapphire/photo2016.php">2016</a> <a href="sapphire/photo2015.php">2015</a> <a href="sapphire/photo30days.php">30 Days</a> <a href="sapphire/photo2014.php">2014</a>
</p>

<p>Blog pictures: 
<a href="blog/photo2015.php">2015</a> <a href="blog/photo2014.php">2014</a> <a href="blog/photo2013.php">2013</a> <a href="blog/photo2012.php">2012</a> <a href="blog/photo2011.php">2011</a>
<a href="blog/photo2010.php">2010</a> <a href="blog/photo2009.php">2009</a> <a href="blog/photo2008.php">2008</a> <a href="blog/photo2007.php">2007</a> <a href="blog/photo2006.php">2006</a>
</p>

<p>$strImage
</p>
$strMenu
END;
}

require('../php/ui/_disp.php');
?>
