<?php
require('php/_myphoto.php');

function EchoMetaDescription($bChinese)
{
	echo 'Woody 2010 personal photos and related links. Travelled coast to coast accross United States for three times this year.';
}

function EchoAll($bChinese)
{
    echo <<<END
<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=235853" target=_blank>Mar 7</a>. My hand in <a href="http://blog.sina.com.cn/s/blog_4930ecbc0100smrk.html" target=_blank>Joshua Tree</a> NP. Photo taken by Wsss <a href="2010/hand.jpg" target=_blank>Large</a>
<br /><img src=2010/hand_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=235853" target=_blank>Mar 20</a>. My foot in Everglades NP. Photo taken by <a href="http://xianfffff.photo.163.com" target=_blank>Diandian</a> <a href="2010/foot_special.jpg" target=_blank>Large</a> <a href="2010/foot_s.jpg" target=_blank>Full view</a> <a href="2010/foot.jpg" target=_blank>Large full view</a>
<br /><img src=2010/foot_special_s.jpg></p>

<!--<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=235853" target=_blank>Mar 23</a>. The end of US highway 1. Photo taken by <a href="http://xianfffff.photo.163.com" target=_blank>Diandian</a> <a href="2010/ushighway1.jpg" target=_blank>Large</a>
<br /><img src=2010/ushighway1_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=235853" target=_blank>Mar 28</a>. It must be hard being a king. Photo taken by <a href="http://xianfffff.photo.163.com" target=_blank>Diandian</a> <a href="2010/elvispresley.jpg" target=_blank>Large</a>
<br /><img src=2010/elvispresley_s.jpg></p>-->

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=235853" target=_blank>Apr 3</a>. <a href="http://blog.sina.com.cn/s/blog_4930ecbc0100pkug.html" target=_blank>Chaco</a> NHP, exploring american indian <a href="http://blog.sina.com.cn/s/blog_4930ecbc0100plkc.html" target=_blank>history</a>. Photo taken by <a href="http://xianfffff.photo.163.com" target=_blank>Diandian</a> <a href="2010/chaco.jpg" target=_blank>Large</a>
<br /><img src=2010/chaco_s.jpg></p>

<p><a href="http://www.lvye.org/modules/lvyebb/viewtopic.php?view=1&post_id=43914589" target=_blank>Aug 22</a>. Under the blue sky of Beijing. Photo taken by Kongling <a href="2010/bluesky.jpg" target=_blank>Large</a>
<br /><img src=2010/bluesky_s.jpg></p>

<p><a href="http://www.go2eu.com/bbs/viewthread.php?tid=289548" target=_blank>Sep 22</a>. Faked leisure. Photo taken by Han Shoupin <a href="2010/lincoln.jpg" target=_blank>Large</a>
<br /><img src=2010/lincoln_s.jpg></p>
END;
}

require('/php/ui/_disp.php');
?>
