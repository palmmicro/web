<?php
// Provide enhanced function replacement of ../palmmicro.js

function _getPalmmicroMenuArray($bChinese)
{
    if ($bChinese)
    {
		return array('aboutus' => '关于我们',
                       'pa6488' => 'PA6488',
                       'pa3288' => 'PA3288',
                       'ar1688' => 'AR1688',
                       'pa1688' => 'PA1688',
                       'res' => '资源共享',
                       'blank' => '',
                       'account' => '我的帐号',
                       'contactus' => '联系方式');
    }
    else
    {
		return array('aboutus' => 'About us',
                       'pa6488' => 'PA6488',
                       'pa3288' => 'PA3288',
                       'ar1688' => 'AR1688',
                       'pa1688' => 'PA1688',
                       'res' => 'Resources',
                       'blank' => '',
                       'account' => 'My Account',
                       'contactus' => 'Contact us');
    }
}

// <A class=A2 HREF="/ar1688/index.html">AR1688</A>
// <A class=A2 HREF="/ar1688/indexcn.html">AR1688</A>
function PalmmicroMenu($strItem, $bChinese)
{
    $arMenu = _getPalmmicroMenuArray($bChinese);
    $strCn = $bChinese ? 'cn' : '';
    echo MenuGetLink("/$strItem/index{$strCn}.html", $arMenu[$strItem]);
}

?>
