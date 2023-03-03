<?php
require('php/_cateyes.php');

function GetTitle($bChinese)
{
	return 'Natural Cat Eye Emerald 5.94ct';
}

function GetMetaDescription($bChinese)
{
	return 'Emerald cat eye 5.94ct stone on ring with GRS report. Taobao store Cat Eyes in Seattle. http://shop58325285.taobao.com/';
}

function EchoAll($bChinese)
{
    echo <<<END
<p><a href="http://en.wikipedia.org/wiki/Emerald" target=_blank>Wiki</a>
<br />Weight: 5.94ct
<br />Dimensions: 10.35 x 9.70 x 8.44mm
</p>

<p>Front
<br /><img src=emerald/594/ring.jpg alt="emerald cat eye 5.94ct on ring" /></p>

<p>With light
<br /><img src=emerald/594/stone.jpg alt="emerald cat eye 5.94ct stone" /></p>

<p>GRS report <a href="emerald/594/large/grs.jpg" target=_blank>Large</a>
<br /><img src=emerald/594/grs.jpg alt="GRS report for emerald cat eye 5.94ct" /></p>

<p>From <a href="http://www.realgems.org/list_of_gemstones/beryl.html" target=_blank>realgems.org</a>:</p>
<blockquote><font color=gray>
<br />Formula Emerald: Be3Al2Si6O18 
<br />Agee, Emerald, Émeraude, Esmeralda, Smaragdas, Smaragdi, Smaragds, Smarald, Smeraldo, Szmaragd, Zamrud, Zümrüt, Ngọc lục bảo, Изумруд, 綠寶石, زمرد, ברקת, มรกต, エメラルド 
<br />Mineral class: silicates 
<br />Crystal system: hexagonal 
<br />Mohs scale: 7.5 - 8 
<br />Density (g/cm3): 2.67 - 2.78 
<br />Refractive index: 1.565 - 1.602 
<br />Color: Green in variations, caused by traces of chrome (Cr3+) which partially replaces the aluminium atoms in the unit cell 
<br />Fluorescence: - 
<br />Pleochroism: green - blue-green - yellow-green 
<br />Largest faceted gemstone: 1,347 ct with inclusions. The 858 ct "Gachala Emerald" from the Vega de San Juan mine in Gachalá (Cundinamarca), is one of the largest emeralds. It was found in 1967, and donated to the Smithsonian Institution by Harry Winston. 
<br />Perfect and without visible inclusions: "Tsar of Russia", 30 ct. 
<br />Deposits: Worldwide. Famous for the best known specimens: Muzo / Vasquez-Yacopi Mining Distr. / Boyacá Dep. / Colombia Chivor / Guavio-Guateque Mining Distr. / Boyacá Dep. / Colombia 
<br />Name: from the Greek word "smáragdos" (green stone)
</font></blockquote>
END;
}

require('../../../php/ui/_disp.php');
?>
